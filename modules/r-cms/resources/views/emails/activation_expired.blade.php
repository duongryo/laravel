@extends('rcms::emails.layout')

@section('content')
    <table data-module="image-full"
        data-thumb="http://www.stampready.net/dashboard/editor/user_uploads/zip_uploads/2019/12/05/k1MTECHOnX6LalR8ZvgzsYdB/_all-in-one/thumbnails/image-full.png"
        width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">

        <tbody>
            <tr>
                <td class="o_bg-light o_px-xs" align="center" data-bgcolor="Bg Light"
                    style="background-color: #f5f9fd;padding-left: 8px;padding-right: 8px;">
                    <!--[if mso]><table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation"
                        style="max-width: 600px;margin: 0 auto;">
                        <tbody>
                            <tr>
                                <td class="o_bg-white o_sans o_text o_text-secondary" align="center" data-bgcolor="Bg White"
                                    data-size="Text Default" data-min="12" data-max="20" data-color="Secondary"
                                    style="font-family: helvetica Neue Arial, sans-serif; margin-top: 0px; margin-bottom: 0px; font-size: 15px; line-height: 25.5px; background-color: rgb(255, 255, 255); color: rgb(66, 70, 81); border-left: solid 1px #E5E5E5;; border-right: solid 1px #E5E5E5;">
                                    <p style="margin-top: 0px;margin-bottom: 0px;">
                                        <img class="o_img-full" src="https://i.imgur.com/jeUTwBp.png" width="600" alt=""
                                            style="max-width: 320px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;width: 100%;"
                                            data-crop="false">
                                    </p>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <!--[if mso]></td></tr></table><![endif]-->
                </td>
            </tr>

        </tbody>
    </table>
    <table data-module="content-lg-left"
    data-thumb="http://www.stampready.net/dashboard/editor/user_uploads/zip_uploads/2019/12/05/k1MTECHOnX6LalR8ZvgzsYdB/_all-in-one/thumbnails/content-lg-left.png"
    width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
        <tbody>
            <tr>
                <td class="o_bg-light o_px-xs" align="center" data-bgcolor="Bg Light"
                    style="background-color: #f5f9fd;padding-left: 8px;padding-right: 8px;">
                    <!--[if mso]><table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation"
                        style="max-width: 600px;margin: 0 auto; ">

                        <tbody>
                            <tr>
                                <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="left"
                                    data-bgcolor="Bg White" data-color="Secondary" data-size="Text Default" data-min="12"
                                    data-max="20"
                                    style="font-family: helvetica Neue Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 15px;line-height: 25.5px;background-color: rgb(255, 255, 255);color: rgb(66, 70, 81);padding: 30px 40px 25px; border-left: solid 1px #E5E5E5; border-right: solid 1px #E5E5E5;">
                                    <p
                                        style="margin-top: 20px;margin-bottom: 15px; font-weight: bold;font-size:24px;line-height: 29px;">
                                        {{ $user->email }} ??i, g??i th??nh vi??n c???a b???n s??? <span style="color:#FF3B30">h???t h???n </span>trong
                                        h??m nay
                                        </span>:((
                                    </p>
                                    <p style="color:#333333; font-size:14px;line-height: 20px;">
                                        H??y nhanh tay gia h???n/n??ng c???p ????? ti???p t???c nh???ng vi???c v???n c??n dang d??? c???a m??nh ng??y
                                        n??o.
                                    </p>

                                    <a href="https://renseo.vn/bang-gia" style="text-decoration: none;">
                                        <button
                                            style="cursor: pointer;background-image: linear-gradient(#268DFF, #007AFF); border:solid 1px rgba(0,0,0,0.1);box-shadow: 0px 0.5px 1px rgba(0,0,0,0.28); color: #ffffff;padding:10px 20px; border-radius: 5px; font-weight:500;font-size:15px">
                                            Gia h???n ngay
                                        </button>
                                    </a>
                                    <p style="border-bottom: solid 1px #E5E5E5; padding-top: 40px; margin: 0px;"></p>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <!--[if mso]></td></tr></table><![endif]-->
                </td>
            </tr>

        </tbody>
    </table>
@endsection