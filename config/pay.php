<?php

return [
    'alipay' => [
        'app_id'         => '2016091400513046',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzLSipS8c361KFBlal/6rOWOCjWAHsjV5t0iakSBziuVCkXD6h570jryBVHSMthePkIzRuCmLcpENyvxex0aIixuAAuEt6mAXo1OofdCvqQWQe6XNWfnBCS018dgHdRit07vLhsxmsrcNbhUDz9ifjtikp3MN5HiNLqlJ3++SK05yiriqZ9UefDmKJ79IP7hkz5JjlxomYBp4cmiQRcFF4Gh3RxcxZ4JgxbeKL11mii2Eq9Qy87dGX1ixrKSf19rNav7YtIaWyCC3fPXBYht7EMFl16+6nqnTGKWavXUEXYXBUHQXwcWSX9Ieu4argYpX+wVimW6lBqrd+1/ldIakRwIDAQAB',
        'private_key'    => 'MIIEpAIBAAKCAQEAs3wRTUPXv2Uc6LXpH45oNqhOUEU1cASjKiVgCsjksdI5mgm+5bCWgJHWeWMncEvEkBbe1txfDVv1hmL/a6ZRA6KsMxr283cLPqbNcku4WvbEFFo51OoIugBwM6c3Nw34iSyUFi1OxjGhRKIoqTNuBA++Io7ti1buj9ZwTVcOM6GIFVBI0NvNoz5V27M06xFzW0GaxP67gkh3sP3dw8RSpbdo9oldqOzdoewqeK3+nXxOmnsOoZ7smZ+68aRNpbmYm6SgEVB9YuUh4ipdANDYepX8BUqvMwEgjZ7mvRa6nXlVisy2sZfJqAlhL2jhyC/Si9+Qb3hqXCYuy6qvqyLeEQIDAQABAoIBAEbRxnXpNgDUIcMEvBZyd1ZRtIzhsgMgIU1o7+txdyNe4tGP1N4Gfmv+n1TINfCOROHh1E2NKIg557f96fCM8Fxx3GZR1m0cZLh00o2tqPFjetzY+Qa0zXqu35bR/OxhO9bMWyYg/HshbBOLtGWG4HsDxy8VnE8lnv3sS+WIWxctlR08bm8BcbUcPVyiYYWjeQ2Y17JXxJkvkTjawXjYZDUdpSQGeg1UwlG7VjVx15Di1XC8qMDZXQbgOBfOmE2WF3rnwEGJSHQzjWBX1SFOAhcESikIdYcSA3dglkXc1gmZ21RyCvOOJ7CtqFjMumpoSw3v5gemDhJKnd4B4o4Ura0CgYEA3vKK+Ja9d9GXCz1cJWqH9ev8sBEGD7PpqyAhKplVnVV9PjI4wRtQwkzejy7MtX0A6ZTec2pRtgvJJBL20RmvRI/WPMl/WmWYp2GsiJqfUz332pDtkSgJfP5lwgQGJmnn4n7C7cGBAgO//lkyT9z7zTK8Qmr9Bqwyt4wZ4qircfcCgYEAzhf+jDIpBR6vRqZhnLuosoRTw39wLr3szur4ftHAQzuEqSvZ6WNCmIpjEpBlZiBPTChjjv6dLOOydxI/wW2nYPSeVRdaFM7eUTh6XrVhgs+i8LRcLmRjIs7jeUNaxPGlawZw7Ww418AclsvoHJMY9cYBxjnSTYm2BpyTvEoFLjcCgYEA2IH564eX3/AuGsAv6DYYav4Nmn4twLobRhAhpVjbB7upsOjcrMt2FfrId4wfSHBonm3vyW2KhJvVba7s+gtTZeW5S7bycjsPkB0OjGp8Jz6aoCr2SmzzKetzroJx5oQaqJ4pdvLf8bDqlnrQnTYhYhjPMkDsD7rSVeU8jhz2wekCgYEAr1N4SDpP7TwabmcS+Wwn6p5qSBE9FXabY7g/aFv2TPvwMp7MhiDcQbrQ57URnhz0eNyPPdHbUpnudB+BP4OSdggEPm1cRAFs3fnHGJUDfG45tr4pAYqDT9RjbgDf0lWknPTg0wpTHTAg4iRbtRtqi4NEdScxgqcZxGwlvnPWDmcCgYADbzYyaMkqTsTfGrQAgZzGfbrNyyTVZ+Ha2W6+3cDUR24FMeChE5vrJ3jRwsaSC2Yqbc2lMT4ZMS2ZV+ULK33gOECZPWir+NUXxTLqXIx7AzXTJXDTBlgdKLclRNRVlMkvwdqrPjyTC4YeuA3AC7+gE2IRdI3SPjT8/lr8pk+yFA==',
        'log'            => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id'      => '',
        'mch_id'      => '',
        'key'         => '',
        'cert_client' => '',
        'cert_key'    => '',
        'log'         => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];