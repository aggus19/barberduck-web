<?php

class Discord extends IP
{
    public static function SendWebhook($title, $content)
    {
        $webhook = "URL_WEBHOOK";

        $timestamp = date("c", strtotime("now"));

        $json_data = json_encode([
            "username" => "Audit Logs",
            "embeds" => [
                [
                    "title" => "$title",
                    "type" => "rich",
                    "description" => "$content",
                    "url" => "https://afagundez.shop/",
                    "timestamp" => $timestamp,
                    "color" => hexdec("2C2F33"),
                    "footer" => [
                        "icon_url" => "https://cdn-icons-png.flaticon.com/512/25/25231.png"
                    ],
                    "avatar_url" => "https://i.imgur.com/ayCu9FL.png",
                    "author" => [
                        "name" => "Barberduck",
                        "url" => "https://afagundez.shop/",
                        "icon_url" => "https://i.imgur.com/ayCu9FL.png"
                    ],
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $ch = curl_init($webhook);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
