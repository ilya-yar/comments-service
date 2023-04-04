<?php

namespace console\controllers;
use common\models\Comment;

use yii\base\Exception;
use yii\console\Controller;

class ParserController extends Controller
{

    /**
     * Сделано на основе поста на хабре:
     * https://habr.com/ru/company/vdsina/blog/537174/
     * Запрос, отдающий список комментариев: https://market.yandex.ru/api/resolve/?r=reviews/product:resolveProductReviewListState
     *
     * @return void
     */
    public function actionYandex(string $url)
    {
        $urlParts = parse_url($url);

        if (empty($urlParts['path'])) {
            throw new Exception('Url path is empty.');
        }
        $path = $urlParts['path'];

        if (empty($urlParts['query'])) {
            throw new Exception('Url query is empty.');
        }
        $query = $urlParts['query'];

        $pathParts = explode('/', $path);

        if (count($pathParts) < 4) {
            throw new Exception('Wrong path.');
        }

        if (strpos($pathParts[1], 'product--') === false) {
            throw new Exception('Wrong product name.');
        }
        $productName = str_replace('product--', '', $pathParts[1]);
        $productId = $pathParts[2];

        $ch = curl_init();
        // Запрос, который отдает список комментариев
        curl_setopt($ch, CURLOPT_URL, 'https://market.yandex.ru/api/resolve/?r=reviews/product:resolveProductReviewListState');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'authority: market.yandex.ru',
            'accept: */*',
            'accept-language: en-US,en;q=0.9',
            'content-type: application/json',
            'origin: https://market.yandex.ru',
            'referer: '.$url,
            'sec-ch-ua: "Google Chrome";v="111", "Not(A:Brand";v="8", "Chromium";v="111"',
            'sec-ch-ua-mobile: ?1',
            'sec-ch-ua-platform: "Android"',
            'sec-fetch-dest: empty',
            'sec-fetch-mode: cors',
            'sec-fetch-site: same-origin',
            'sk: s8ae8a667ff71dbeed0f3b1af5374494d',
            'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Mobile Safari/537.36',
            'x-market-core-service: <UNKNOWN>',
            'x-requested-with: XMLHttpRequest',
            'x-retpath-y: '.$url,
            'accept-encoding: gzip',
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'i=F0E+rvrFqiCPBx1IkDZITcD095DBJngBxM6NSvrWmzU6Jrt7FjXFzcOUJvLGottLD1rFDAS9wUnGsKNZkiIECCrX1Aw=; yandexuid=9584339031680537822; yuidss=9584339031680537822; ymex=1995897823.yrts.1680537823; gdpr=0; _ym_uid=1680537824440573705; _ym_d=1680537824; _ym_visorc=w; _ym_isad=2; spravka=dD0xNjgwNTM3ODM3O2k9OTQuMjUuMjM5Ljc0O0Q9RTE5MEVBMzQzOUU1MThFQkNFOTY5NEFBODJCRERBNDQzQjMzQ0IyRDAxRjU1MkY0QUJBRUQ4Qzk0Rjc4MDkzMEU2QjcxM0Q2M0EwMkNGNUI3Njc3QTdERkJBRjY3QjNDO3U9MTY4MDUzNzgzNzQ1ODk1NjkwMztoPTNkOTFjNGVmNDhjYmM5YWM4MTVkNDUxMzZkMGJkNTMw; visits=1680537837-1680537837-1680537837; cmp-merge=true; reviews-merge=true; skid=5104942541680537837; js=1; report_hint=20230403_1416; ugcp=1; nec=0; currentRegionId=16; currentRegionName=%D0%AF%D1%80%D0%BE%D1%81%D0%BB%D0%B0%D0%B2%D0%BB%D1%8C; mOC=1; is_gdpr=0; is_gdpr_b=CPzoGBDTrwE=; bh=EkAiR29vZ2xlIENocm9tZSI7dj0iMTExIiwgIk5vdChBOkJyYW5kIjt2PSI4IiwgIkNocm9taXVtIjt2PSIxMTEiKgI/MToJIkFuZHJvaWQi; _yasc=hXRGk2P02NxiO5Q39LaSf1pqD8mInndChb7j5jKxjPgnawI8a7Cq6sbMf7WKOl58mfec3g==; no-pda-redir=1; parent_reqid_seq=1680537837551%2F0e19dedaacc40006efbdd6b470f80500%2C1680538335648%2F65021ebeef8cae81e71a87d270f80500');
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"params":[{"productId":'.$productId.',"pageNum":1,"withPhoto":false,"restParams":{"slug":"'.$productName.'","no-pda-redir":"1"},"sortBy":"date","sortType":"desc"}],"path":"'.$path.'?'.$query.'"}');

        $response = curl_exec($ch);

        $savedResponse = '{"results":[{"data":{"result":[{"entity":"productReviewListState","id":"productReviewListState"}],"collections":{"publicUser":{"22699497":{"entity":"publicUser","uid":"22699497","publicDisplayName":"Рафаэль Ульмаскулов","isDisplayNameEmpty":true,"isDeleted":false,"avatar":"//avatars.mds.yandex.net/get-yapic/0/0-0/islands-retina-50","publicId":"8bdwd4ge0kqju1ny98xmtea91r","verified":false,"avatar2x":"//avatars.mds.yandex.net/get-yapic/0/0-0/islands-200","grades":8,"social":[]},"197977837":{"entity":"publicUser","uid":"197977837","publicDisplayName":"Наталья Савченко","isDisplayNameEmpty":true,"isDeleted":false,"avatar":"//avatars.mds.yandex.net/get-yapic/0/0-0/islands-retina-50","publicId":"244tnjfp1n523vntfjqf5jv0wg","verified":false,"avatar2x":"//avatars.mds.yandex.net/get-yapic/0/0-0/islands-200","grades":1,"social":[]},"456167027":{"entity":"publicUser","uid":"456167027","publicDisplayName":"MARSOC","isDisplayNameEmpty":true,"isDeleted":false,"avatar":"//avatars.mds.yandex.net/get-yapic/54535/XWpfRqClat4zKwAr3mNX0MbBEUU-1/islands-retina-50","publicId":"0h1wm7wagq5g6uvkpab1uudj4w","verified":false,"avatar2x":"//avatars.mds.yandex.net/get-yapic/54535/XWpfRqClat4zKwAr3mNX0MbBEUU-1/islands-200","grades":46,"social":[]},"893856952":{"entity":"publicUser","uid":"893856952","publicDisplayName":"Вероника П.","isDisplayNameEmpty":true,"isDeleted":false,"avatar":"//avatars.mds.yandex.net/get-yapic/33202/wg8gqqTNlpMaMaEWYZELQ6mRXJo-1/islands-retina-50","publicId":"8utzc2wweq6wu7dg5xydd95m1w","verified":false,"avatar2x":"//avatars.mds.yandex.net/get-yapic/33202/wg8gqqTNlpMaMaEWYZELQ6mRXJo-1/islands-200","grades":3,"social":[]},"980305038":{"entity":"publicUser","uid":"980305038","publicDisplayName":"Артём Непочатов","isDisplayNameEmpty":true,"isDeleted":false,"avatar":"//avatars.mds.yandex.net/get-yapic/36689/CHPfMEFuPSvylUuxjFnUhEDSBPs-1/islands-retina-50","publicId":"u0pdkuxhb9xxa5jmevc68gqrhm","verified":false,"avatar2x":"//avatars.mds.yandex.net/get-yapic/36689/CHPfMEFuPSvylUuxjFnUhEDSBPs-1/islands-200","grades":8,"social":[]},"1429180293":{"entity":"publicUser","uid":"1429180293","publicDisplayName":"Лейля Абдуллина","isDisplayNameEmpty":true,"isDeleted":false,"avatar":"//avatars.mds.yandex.net/get-yapic/0/0-0/islands-retina-50","publicId":"z8xvpz98cachzhwjaqvrex517c","verified":false,"avatar2x":"//avatars.mds.yandex.net/get-yapic/0/0-0/islands-200","grades":6,"social":[]},"1473045728":{"entity":"publicUser","uid":"1473045728","publicDisplayName":"vova shaposhnicov","isDisplayNameEmpty":true,"isDeleted":false,"avatar":"//avatars.mds.yandex.net/get-yapic/53031/HI9mclNXhaS7baXIMjjnvsqCI-1/islands-retina-50","publicId":"e5ky2bzezzmn4tur19ak4df6wg","verified":false,"avatar2x":"//avatars.mds.yandex.net/get-yapic/53031/HI9mclNXhaS7baXIMjjnvsqCI-1/islands-200","grades":2,"social":[]},"1500202793":{"entity":"publicUser","uid":"1500202793","publicDisplayName":"Alex Яр","isDisplayNameEmpty":true,"isDeleted":false,"avatar":"//avatars.mds.yandex.net/get-yapic/0/0-0/islands-retina-50","publicId":"enwcp1xb7nx3wqdubmd10gh088","verified":false,"avatar2x":"//avatars.mds.yandex.net/get-yapic/0/0-0/islands-200","grades":2,"social":[]},"1652729744":{"entity":"publicUser","uid":"1652729744","publicDisplayName":"PavEl","isDisplayNameEmpty":true,"isDeleted":false,"avatar":"//avatars.mds.yandex.net/get-yapic/0/0-0/islands-retina-50","publicId":"u7pgctx10nf0v8veemurd5jahc","verified":false,"avatar2x":"//avatars.mds.yandex.net/get-yapic/0/0-0/islands-200","grades":4,"social":[]}},"review":{"199167586":{"entity":"review","id":"199167586","isCpa":true,"recommend":true,"productId":1772726467,"userId":980305038,"anonymous":0,"created":1680420696287,"averageGrade":4,"comment":"Телефон хороший, меня полностью устраивает, но как человек, у которого выброрежим даже дома, иногда могу пропустить сообщения","pro":"Быстрый и выглядит стильно","contra":"Слабый виброотклик","type":1,"usage":0,"votes":{"agree":0,"reject":0,"total":0,"isActive":true},"photos":[],"provider":{"type":null,"name":null},"region":{"entity":"region","name":"Санкт-Петербург"},"factors":[{"factorId":746,"value":5,"title":"Производительность","factorType":0,"count":1,"factorStatistic":null},{"factorId":743,"value":4,"title":"Камера","factorType":0,"count":1,"factorStatistic":null},{"factorId":745,"value":5,"title":"Объем памяти","factorType":0,"count":1,"factorStatistic":null},{"factorId":744,"value":5,"title":"Время автономной работы","factorType":0,"count":1,"factorStatistic":null},{"factorId":742,"value":5,"title":"Экран","factorType":0,"count":1,"factorStatistic":null}]},"199180607":{"entity":"review","id":"199180607","isCpa":true,"recommend":true,"productId":1772726467,"anonymous":1,"created":1680425227117,"averageGrade":4,"comment":null,"pro":"Понравился экран, камера, батарея долго держит заряд.","contra":"Звук. \nТихий звук вызова. Звук из в строенных динамиков очень не приятный.  Непонятно как работает громкость по блютузу. Если поднимаешь трубку в машине через громкую связь в магнитоле, то первые секунд 10-15 очень тихий звук. Ты выкручиваешь громкость на полную чтобы что-то услышать, и тут он просыпается и врубает свою громкость, и ты лихорадочно крутишь громкость на магнитоле назад. С прошлым телефоном такой напасти не было.","type":1,"usage":1,"votes":{"agree":0,"reject":0,"total":0,"isActive":true},"photos":[],"provider":{"type":null,"name":null},"region":{"entity":"region","name":"Смоленск"},"factors":[{"factorId":745,"value":5,"title":"Объем памяти","factorType":0,"count":1,"factorStatistic":null},{"factorId":743,"value":5,"title":"Камера","factorType":0,"count":1,"factorStatistic":null},{"factorId":746,"value":5,"title":"Производительность","factorType":0,"count":1,"factorStatistic":null},{"factorId":742,"value":5,"title":"Экран","factorType":0,"count":1,"factorStatistic":null},{"factorId":744,"value":5,"title":"Время автономной работы","factorType":0,"count":1,"factorStatistic":null}]},"199190435":{"entity":"review","id":"199190435","isCpa":true,"recommend":true,"productId":1772726467,"userId":22699497,"anonymous":0,"created":1680428628801,"averageGrade":5,"comment":"Хороший телефон за такую цену (брал за ~17600р.)\nВ остальном обычный смартфон. Работает быстро.","pro":"Цена/качество","contra":"Не обнаружено","type":1,"usage":1,"votes":{"agree":0,"reject":0,"total":0,"isActive":true},"photos":[],"provider":{"type":null,"name":null},"region":{"entity":"region","name":"Уфа"},"factors":[{"factorId":745,"value":5,"title":"Объем памяти","factorType":0,"count":1,"factorStatistic":null},{"factorId":742,"value":5,"title":"Экран","factorType":0,"count":1,"factorStatistic":null},{"factorId":743,"value":4,"title":"Камера","factorType":0,"count":1,"factorStatistic":null},{"factorId":746,"value":5,"title":"Производительность","factorType":0,"count":1,"factorStatistic":null},{"factorId":744,"value":4,"title":"Время автономной работы","factorType":0,"count":1,"factorStatistic":null}]},"199222664":{"entity":"review","id":"199222664","isCpa":true,"recommend":true,"productId":1772726467,"userId":1473045728,"anonymous":0,"created":1680437390325,"averageGrade":5,"comment":null,"pro":"Экран,автономность, вобщем за такую цену просто супер!! Еще запись звонков из коробки без предупреждения собеседника. Купил и не жалею.","contra":null,"type":1,"usage":1,"votes":{"agree":0,"reject":0,"total":0,"isActive":true},"photos":[],"provider":{"type":null,"name":null},"region":{"entity":"region","name":"Новосибирск"},"factors":[{"factorId":746,"value":5,"title":"Производительность","factorType":0,"count":1,"factorStatistic":null},{"factorId":743,"value":4,"title":"Камера","factorType":0,"count":1,"factorStatistic":null},{"factorId":742,"value":5,"title":"Экран","factorType":0,"count":1,"factorStatistic":null},{"factorId":745,"value":5,"title":"Объем памяти","factorType":0,"count":1,"factorStatistic":null},{"factorId":744,"value":5,"title":"Время автономной работы","factorType":0,"count":1,"factorStatistic":null}]},"199260108":{"entity":"review","id":"199260108","isCpa":true,"recommend":false,"productId":1772726467,"userId":893856952,"anonymous":0,"created":1680448397347,"averageGrade":5,"comment":"Перешёл с айфона xr вообще не жалею , крутой телефон .","pro":"Крутой","contra":"Камера","type":1,"usage":1,"votes":{"agree":0,"reject":1,"total":1,"isActive":true},"photos":[],"provider":{"type":null,"name":null},"region":{"entity":"region","name":"Краснодар"},"factors":[{"factorId":744,"value":5,"title":"Время автономной работы","factorType":0,"count":1,"factorStatistic":null},{"factorId":745,"value":5,"title":"Объем памяти","factorType":0,"count":1,"factorStatistic":null},{"factorId":743,"value":3,"title":"Камера","factorType":0,"count":1,"factorStatistic":null},{"factorId":746,"value":5,"title":"Производительность","factorType":0,"count":1,"factorStatistic":null},{"factorId":742,"value":5,"title":"Экран","factorType":0,"count":1,"factorStatistic":null}]},"199287674":{"entity":"review","id":"199287674","isCpa":true,"recommend":true,"productId":1772726467,"userId":1429180293,"anonymous":0,"created":1680456578831,"averageGrade":5,"comment":null,"pro":"Все отлично","contra":"Нет","type":1,"usage":1,"votes":{"agree":0,"reject":0,"total":0,"isActive":true},"photos":[],"provider":{"type":null,"name":null},"region":{"entity":"region","name":"Альметьевск"},"factors":[{"factorId":746,"value":5,"title":"Производительность","factorType":0,"count":1,"factorStatistic":null},{"factorId":745,"value":5,"title":"Объем памяти","factorType":0,"count":1,"factorStatistic":null},{"factorId":742,"value":5,"title":"Экран","factorType":0,"count":1,"factorStatistic":null},{"factorId":743,"value":5,"title":"Камера","factorType":0,"count":1,"factorStatistic":null},{"factorId":744,"value":5,"title":"Время автономной работы","factorType":0,"count":1,"factorStatistic":null}]},"199325722":{"entity":"review","id":"199325722","isCpa":true,"recommend":true,"productId":1772726467,"userId":1500202793,"anonymous":0,"created":1680470247956,"averageGrade":5,"comment":"Один из самых лучших флагманов на рынке","pro":"Лучше устройства за такие деньги не найти","contra":"Недостатков не имеет","type":1,"usage":0,"votes":{"agree":0,"reject":0,"total":0,"isActive":true},"photos":[],"provider":{"type":null,"name":null},"region":{"entity":"region","name":"Москва"},"factors":[{"factorId":744,"value":5,"title":"Время автономной работы","factorType":0,"count":1,"factorStatistic":null},{"factorId":742,"value":5,"title":"Экран","factorType":0,"count":1,"factorStatistic":null},{"factorId":745,"value":5,"title":"Объем памяти","factorType":0,"count":1,"factorStatistic":null},{"factorId":743,"value":5,"title":"Камера","factorType":0,"count":1,"factorStatistic":null},{"factorId":746,"value":4,"title":"Производительность","factorType":0,"count":1,"factorStatistic":null}]},"199346995":{"entity":"review","id":"199346995","isCpa":true,"recommend":true,"productId":1772726467,"userId":197977837,"anonymous":0,"created":1680502017048,"averageGrade":5,"comment":"Покупкой довольна","pro":"Мощный, красивый, удобный","contra":"Пока не обнаружено","type":1,"usage":1,"votes":{"agree":0,"reject":0,"total":0,"isActive":true},"photos":[],"provider":{"type":null,"name":null},"region":{"entity":"region","name":"Ростов-на-Дону"},"factors":[{"factorId":743,"value":5,"title":"Камера","factorType":0,"count":1,"factorStatistic":null},{"factorId":745,"value":5,"title":"Объем памяти","factorType":0,"count":1,"factorStatistic":null},{"factorId":742,"value":5,"title":"Экран","factorType":0,"count":1,"factorStatistic":null},{"factorId":744,"value":5,"title":"Время автономной работы","factorType":0,"count":1,"factorStatistic":null},{"factorId":746,"value":5,"title":"Производительность","factorType":0,"count":1,"factorStatistic":null}]},"199362603":{"entity":"review","id":"199362603","isCpa":true,"recommend":true,"productId":1772726467,"userId":456167027,"anonymous":0,"created":1680507924278,"averageGrade":5,"comment":"Достойный выбор за свои деньги. Рекомендую.","pro":"Цена, качество.","contra":"Нет","type":1,"usage":1,"votes":{"agree":0,"reject":0,"total":0,"isActive":true},"photos":[],"provider":{"type":null,"name":null},"region":{"entity":"region","name":"Ульяновск"},"factors":[{"factorId":746,"value":5,"title":"Производительность","factorType":0,"count":1,"factorStatistic":null},{"factorId":744,"value":5,"title":"Время автономной работы","factorType":0,"count":1,"factorStatistic":null},{"factorId":742,"value":5,"title":"Экран","factorType":0,"count":1,"factorStatistic":null},{"factorId":745,"value":5,"title":"Объем памяти","factorType":0,"count":1,"factorStatistic":null},{"factorId":743,"value":5,"title":"Камера","factorType":0,"count":1,"factorStatistic":null}]},"199380944":{"entity":"review","id":"199380944","isCpa":true,"recommend":true,"productId":1772726467,"userId":1652729744,"anonymous":0,"created":1680514381538,"averageGrade":5,"comment":null,"pro":"неплохой, шустрый аппарат, за такие деньги. брал 31.03.2023 за 16000р\nв ладони удобен,, края закругленные красиво, не прямоугольник, тоненький, но может я сравниваю со своим F150-R2022 ярче моего, хотя частота экрана такая же 90Гц.","contra":null,"type":1,"usage":0,"votes":{"agree":0,"reject":0,"total":0,"isActive":true},"photos":[],"provider":{"type":null,"name":null},"region":{"entity":"region","name":"Самара"},"factors":[{"factorId":743,"value":4,"title":"Камера","factorType":0,"count":1,"factorStatistic":null},{"factorId":745,"value":5,"title":"Объем памяти","factorType":0,"count":1,"factorStatistic":null},{"factorId":742,"value":5,"title":"Экран","factorType":0,"count":1,"factorStatistic":null},{"factorId":744,"value":4,"title":"Время автономной работы","factorType":0,"count":1,"factorStatistic":null},{"factorId":746,"value":4,"title":"Производительность","factorType":0,"count":1,"factorStatistic":null}]}},"pager":{"5854a427":{"pageNum":1,"pages":[{"num":1,"current":true},{"num":2,"current":false},{"num":3,"current":false},{"num":4,"current":false},{"num":5,"current":false},{"num":6,"current":false},{"num":7,"current":false},{"num":8,"current":false}],"pageSize":10,"count":1105,"total":1105,"totalPageCount":111,"type":"productReview","id":"5854a427","entity":"pager"}},"productReviewListState":{"productReviewListState":{"entity":"productReviewListState","id":"productReviewListState","pagerId":"5854a427","reviewIds":[199380944,199362603,199346995,199325722,199287674,199260108,199222664,199190435,199180607,199167586],"isLoaded":true,"showProductGrades":false,"textReviewsCount":1105,"gradesCount":0,"sorters":[{"text":"по дате","options":[{"id":"date","type":"desc","isActive":true}]},{"text":"по оценке","options":[{"id":"grade","type":"desc","isActive":false}]},{"text":"по полезности","options":[{"id":"rank","type":"desc","isActive":false}]}],"currentListStateParams":{"productId":1772726467,"pageNum":1,"withPhoto":false,"restParams":{"slug":"smartfon-realme-10","no-pda-redir":"1"},"sortBy":"date","sortType":"desc"},"appliedListStateParams":{"productId":1772726467,"pageNum":1,"withPhoto":false,"restParams":{"slug":"smartfon-realme-10","no-pda-redir":"1"},"sortBy":"date","sortType":"desc"}}}}}}]}';


        curl_close($ch);

        try {
            $data = json_decode($response, true);
            $comments = $data['results'][0]['data']['collections']['review'];
            $users = $data['results'][0]['data']['collections']['publicUser'];

            foreach ($comments as $comment) {
                if (empty($comment['userId'])) {
                    continue;
                }
                if (empty($users[$comment['userId']]['publicDisplayName'])) {
                    continue;
                }
                $model = new Comment([
                    'subject' => $productName,
                    'subject_id' => $comment['productId'],
                    'username' => $users[$comment['userId']]['publicDisplayName'],
                    'comment' => $comment['comment'],
                    'created_at' => date('Y-m-d H:i:s', (int)(substr($comment['created'], 0, -3))),
                ]);
                if ($model->validate()) {
                    $model->save();
                } else {
                    echo"Comment validation error: ".print_r($model->getErrors(), true);
                }
            }
        }
        catch (\Throwable $e) {
            echo "Error while parsing response: ".$e->getMessage();
            return;
        }
    }
}