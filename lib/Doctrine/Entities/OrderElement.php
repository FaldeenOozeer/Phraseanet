<?php

namespace Entities;

use Alchemy\Phrasea\Application;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderElement
 */
class OrderElement
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $order_master_id;

    /**
     * @var boolean
     */
    private $deny;

    /**
     * @var \Entities\Basket
     */
    private $basket;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set order_master_id
     *
     * @param integer $orderMasterId
     * @return OrderElement
     */
    public function setOrderMasterId($orderMasterId)
    {
        $this->order_master_id = $orderMasterId;

        return $this;
    }

    /**
     * Get order_master_id
     *
     * @return integer
     */
    public function getOrderMasterId()
    {
        return $this->order_master_id;
    }

    /**
     *
     * Returns the username matching to the order_master_id
     *
     * @param Application $app
     * @return string
     */
    public function getOrderMasterName(Application $app)
    {
        if (isset($this->order_master_id) && null !== $this->order_master_id) {
            $user = \User_Adapter::getInstance($this->order_master_id, $app);

            return $user->get_firstname();
        }

        return null;
    }

    /**
     * Set deny
     *
     * @param boolean $deny
     * @return OrderElement
     */
    public function setDeny($deny)
    {
        $this->deny = $deny;

        return $this;
    }

    /**
     * Get deny
     *
     * @return boolean
     */
    public function getDeny()
    {
        return $this->deny;
    }

    /**
     * Set basket
     *
     * @param \Entities\Basket $basket
     * @return OrderElement
     */
    public function setBasket(\Entities\Basket $basket = null)
    {
        $this->basket = $basket;

        return $this;
    }

    /**
     * Get basket
     *
     * @return \Entities\Basket
     */
    public function getBasket()
    {
        return $this->basket;
    }
    /**
     * @var integer
     */
    private $order_id;

    /**
     * @var integer
     */
    private $base_id;

    /**
     * @var integer
     */
    private $record_id;


    /**
     * Set order_id
     *
     * @param integer $orderId
     * @return OrderElement
     */
    public function setOrderId($orderId)
    {
        $this->order_id = $orderId;

        return $this;
    }

    /**
     * Get order_id
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set base_id
     *
     * @param integer $baseId
     * @return OrderElement
     */
    public function setBaseId($baseId)
    {
        $this->base_id = $baseId;

        return $this;
    }

    /**
     * Get base_id
     *
     * @return integer
     */
    public function getBaseId()
    {
        return $this->base_id;
    }

    /**
     * Set record_id
     *
     * @param integer $recordId
     * @return OrderElement
     */
    public function setRecordId($recordId)
    {
        $this->record_id = $recordId;

        return $this;
    }

    /**
     * Get record_id
     *
     * @return integer
     */
    public function getRecordId()
    {
        return $this->record_id;
    }
    /**
     * @var \Entities\Order
     */
    private $order;


    /**
     * Set order
     *
     * @param \Entities\Order $order
     * @return OrderElement
     */
    public function setOrder(\Entities\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Entities\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Returns a record from the element's base_id and record_id
     *
     * @param Application $app
     * @return \record_adapter
     */
    public function getRecord(Application $app)
    {
        return new \record_adapter($app, $this->getSbasId($app), $this->getRecordId());
    }

    /**
     * Returns the matching sbasId
     *
     * @param Application $app
     * @return int
     */
    public function getSbasId(Application $app)
    {
        return \phrasea::sbasFromBas($app, $this->getBaseId());
    }
}