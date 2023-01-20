# Jurager/Commerce
[![Latest Stable Version](https://poser.pugx.org/jurager/commerce/v/stable)](https://packagist.org/packages/jurager/commerce)
[![Total Downloads](https://poser.pugx.org/jurager/commerce/downloads)](https://packagist.org/packages/jurager/commerce)
[![PHP Version Require](http://poser.pugx.org/jurager/commerce/require/php)](https://packagist.org/packages/jurager/commerce)
[![License](https://poser.pugx.org/jurager/commerce/license)](https://packagist.org/packages/jurager/commerce)

Библиотека для универсального разбора [CommerceML2](http://v8.1c.ru/edi/edi_stnd/90/92.htm) файлов.

# Установка
`composer require jurager/commerce`

# Каталог и товары

```php
$cml = new Commerce();

$cml->loadImportXml('/path/import.xml'); // Загружаем товары
$cml->loadOffersXml('/path/offers.xml'); // Загружаем предложения
```

# Работа с товарами и предложениями

```php
foreach ($cml->products as $product){
    echo $product->name; // Выводим название товара (Товары->Товар->Наименование)
    foreach ($product->offers as $offer){
        echo $offer->name; // Выводим название предложения (Предложения->Предложение->Наименование)
        echo $offer->prices[0]->cost; // Выводим первую цену предложения (Предложения->Предложение->Цены->Цена->ЦенаЗаЕдиницу)
    }
}
```

## \Jurager\Commerce\Commerce

| Метод        | XML              | Описание              |
|--------------|------------------|-----------------------|
| catalog      | Каталог          | Объект каталога       |
| classifier   | Классификатор    | Объект классификатора |
| offerPackage | ПакетПредложений | Объект предложений    |

## \Jurager\Commerce\Model\OfferPackage

| Метод      | XML                      | Описание                |
|------------|--------------------------|-------------------------|
| offers     | Предложения->Предложение | Список всех предложений |
| priceTypes | ТипыЦен->ТипЦены         | Список всех типов цен   |

## \Jurager\Commerce\Model\Product

| Метод      | XML                                                           | Описание                                             |
|------------|---------------------------------------------------------------|------------------------------------------------------|
| properties | Каталог->Товары->Товар->ЗначенияСвойств                       | Свойства продукта, `$product->properties[0]->value`  |
| requisites | Каталог->Товары->Товар->ЗначенияРеквизитов->ЗначениеРеквизита | Реквизиты продукта, `$product->requisites[0]->value` |
| offers     | Предложения->Предложение                                      | Список предложений для продукта                      |
| group      | Каталог->Товары->Товар->Группы=>Классификатор->группы->группа | Группа товара `$product->group->name`                |
| images     | Каталог->Товары->Товар->Картинка                              | Список картинок у товара                             |

## \Jurager\Commerce\Model\Offer

| Метод          | XML                                                                  | Описание                              |
|----------------|----------------------------------------------------------------------|---------------------------------------|
| prices         | Предложения->Предложение->Цены->Цена                                 | Все цены предложения                  |
| specifications | Предложения->Предложение->ХарактеристикиТовара->ХарактеристикаТовара | Список всех характеристик предложения |

# Лицензия
Данный пакет является открытым кодом под лицензией [MIT license](LICENSE).
