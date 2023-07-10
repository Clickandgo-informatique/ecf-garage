<?php
 
namespace App\Utils;
 
class PaginationResult
{
    private $items;
    private $totalItems;
 
    public function __construct($items, $totalItems)
    {
        $this->items = $items;
        $this->totalItems = $totalItems;
    }
 
    public function getItems()
    {
        return $this->items;
    }
 
    public function getTotalItems()
    {
        return $this->totalItems;
    }
}