<?php
/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2015 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Alchemy\Phrasea\Controller;

use Alchemy\Phrasea\Application;
use Alchemy\Phrasea\Authorization\AuthorizationChecker;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class BaseController
{
    /** @var Application */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return \User_Adapter
     */
    public function getAuthenticatedUser()
    {
        return $this->app['authentication']->getUser();
    }

    public function render($view, array $parameters = [], Response $response = null)
    {
        /** @var \Twig_Environment $twig */
        $twig = $this->app['twig'];

        if ($response instanceof StreamedResponse) {
            $response->setCallback(function () use ($twig, $view, $parameters) {
                $twig->display($view, $parameters);
            });

            return $response;
        }

        if (null === $response) {
            $response = new Response();
        }
        $response->setContent($twig->render($view, $parameters));

        return $response;
    }

    /**
     * @param mixed $formType
     * @param mixed $data
     * @return FormInterface
     */
    public function createApiForm($formType, $data, array $options = [])
    {
        return $this->app['form.factory']->createNamed(
            'data',
            $formType,
            $data,
            array_merge(['csrf_protection' => false], $options)
        );
    }

    /**
     * @param mixed $formType
     * @param mixed $data
     * @return FormBuilderInterface
     */
    public function createApiFormBuilder($formType = 'form', $data = null, array $options = [])
    {
        return $this->app['form.factory']->createNamedBuilder(
            'data',
            $formType,
            $data,
            array_merge(['csrf_protection' => false], $options)
        );
    }

    /**
     * @param mixed $attributes
     * @param mixed $object
     * @return bool
     */
    public function isGranted($attributes, $object = null)
    {
        /** @var AuthorizationChecker $authorizationChecker */
        $authorizationChecker = $this->app['phraseanet.authorization_checker'];

        return $authorizationChecker->isGranted($attributes, $object);
    }
}