<?php

foreach($data['items'] as $item){
  echo $item->itemTitle . ' - ' . $item->itemDescription . '<br>';
}