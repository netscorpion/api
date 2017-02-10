Работа с транзакциями <span id="trz"></span>
=========================

> Note: Функционал работы с транзакциями в версии 0.2 не был изменен и полностью соответствует версии 0.1

Для получения данных по транзакциям использщуются запросы следующего вида.

~~~html
http://rest.neftika-card.ru/v02/tranzs?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=
~~~

По умолчанию выдаются данные по транзакция за последние сутки точнее с `00:00` предедущего дня по текущий момент.

### Переменные <span id="card-var"></span>

Имя         |  Значение
------------|----------------------------------------------------
sDate       | Дата начала выгрузки
eDate       | Дата конца выгрузки
card        | Карта по которой необходимо получить транзакции
page        | Номер выводимой страницы
per-page    | Количество записей на странице

> Note: `eDate` не может использоватся без указания `sDate`. Если `eDate` меньше чем `sDate` то данные берутся за сутки соответствующие `sDate`

### Выходные данные <span id="card-outdata"></span>

*tranzs* массив выгружаемых транзакций

Индекс                  | Значение
------------------------|---------------------
MDATA                   | Дата
ID_KLIENTA              | Идентификатор клиента
GR_NOMER                | Графический номер карты
ID_KOSH_ZA_CHTO         | Идентификатор кошелька (услуги) эмитента карты
ID_KOSH_GLOBAL          | Идентификатор кошелька (услуги) глобальный
DESCRIPTION_KOSH_ZA_CHTO | Описание кошелька (услуги)
OPERATZIYA              |Операция (1 - дебет, 0 - кредит)
ID_PRICHINY             |
DESCRIPTION_PRICHINY    | Описание операции
SUMMA_ZA_CHTO           | Количество услуги
TERMINAL_COST           | Цена терминала
TERMINAL_SUMM           | Сумма полученная с терминала
DISCONT_COST            | Цена с проведенной скидкой
DISCONT_SUMM            | Сумма с проведенной скидкой
DELTA_PRICE             | Дельта предоставленной скидки
EM_GDE_OBSL             | Идентификатор эмитента где произошло обслуживание
NOMER_TERMINALA         | Номер терминала где произошло обслуживание
ID_TO                   | Идентификатор ТО
NAME_TO                 | Название ТО
ADDRESS_TO              | Адрес ТО
TRN_GUID                | Уникальный идентификатор транзакции

Пример построения запросов <span id="trz-quest"></span>
------------------------

~~~html
http://rest.neftika-card.ru/v02/tranzs?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=
http://rest.neftika-card.ru/v02/tranzs?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&sDate=01.01.2017
http://rest.neftika-card.ru/v02/tranzs?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&sDate=01.01.2017&eDate=10.01.2017
http://rest.neftika-card.ru/v02/tranzs?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=&sDate=01.01.2017&eDate=10.01.2017&card=648047445
~~~

### Пример использования <span id="trz-exp"></span>

~~~html
http://rest.neftika-card.ru/v02/tranzs?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY=
~~~

~~~json
{
"tranzs": [
    {
        "MDATA": "19.01.2017 00:47:41",
        "ID_KLIENTA": "823",
        "GR_NOMER": "648021534",
        "ID_KOSH_ZA_CHTO": "4",
        "ID_KOSH_GLOBAL": "16",
        "DESCRIPTION_KOSH_ZA_CHTO": "Аи-92",
        "OPERATZIYA": "1",
        "ID_PRICHINY": "11",
        "DESCRIPTION_PRICHINY": "Дебет карты",
        "SUMMA_ZA_CHTO": "70",
        "TERMINAL_COST": "35.7",
        "TERMINAL_SUMM": "2499",
        "DISCONT_COST": "35.7",
        "DISCONT_SUMM": "2499",
        "DELTA_PRICE": "0",
        "EM_GDE_OBSL": "861",
        "NOMER_TERMINALA": "1045",
        "ID_TO": "45",
        "NAME_TO": "АЗС № 0045 ГПН",
        "ADDRESS_TO": "Лен. обл., г. Приозерск,  Ленинградское шоссе, д.84",
        "TRN_GUID": "094C9265EB3B18A897AD0003814C09BC",
        "ROWNUMID": "1"
    },
 ],
"_links": {
    "self": {
        "href": "http://rest.neftika-card.ru/v02/tranzs?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&%D0%B5Date=01.01.2017&page=1"
    },
    "next": {
        "href": "http://rest.neftika-card.ru/v02/tranzs?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&%D0%B5Date=01.01.2017&page=2"
    },
    "last": {
        "href": "http://rest.neftika-card.ru/v02/tranzs?hash=Tm90aWNlIHRoYXQgeW91IGJpbmQgdGhlIHBsYWNlaG9sZGVyZGY%3D&%D0%B5Date=01.01.2017&page=13"
    }
},
"_meta": {
    "totalCount": "242",
    "pageCount": 13,
    "currentPage": 1,
    "perPage": 20
}
}
~~~
