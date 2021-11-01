<php

class ShoppingOrderRepository extends ServiceEntityRepository
{
	    public function getRevenueOverTimeDate($shopUuid, $startDate, $endDate)
    {
        return $this->createQueryBuilder('shoppingOrder')
            ->innerJoin('shoppingOrder.shoppingBasket', "shoppingBasket")
            ->innerJoin('shoppingOrder.ownerPayed', "ownerPayed")
            ->innerJoin('shoppingBasket.shop', "shop")
            ->where('shop.uuid = :shopUuid AND shoppingOrder.type= :isDone AND shoppingOrder.createdAt BETWEEN :startDate AND :endDate')
            ->setParameter('shopUuid', $shopUuid)
            ->setParameter('isDone', ShoppingOrderTypeEnum::DONE)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->select("
                DATE(shoppingOrder.createdAt) as name,
                sum(shoppingOrder.totalPrice) as value
            ")
            ->groupBy('name')
            ->orderBy('name', 'asc')
            ->getQuery()
            ->getResult();
    }
}
