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
                                        <td class="o_bg-white o_sans o_text o_text-secondary" align="center"
                                             data-bgcolor="Bg White" data-size="Text Default" data-min="12" data-max="20"
                                             data-color="Secondary"
                                             style="font-family: helvetica Neue Arial, sans-serif; margin-top: 0px; margin-bottom: 0px; font-size: 15px; line-height: 25.5px; background-color: rgb(255, 255, 255); color: rgb(66, 70, 81); border-left: solid 1px #E5E5E5; border-right: solid 1px #E5E5E5;">
                                             <p style="margin-top: 0px;margin-bottom: 0px;">
                                                  <img class="o_img-full"
                                                       src="https://i.imgur.com/ZmW0FtD.png"
                                                       width="600" alt=""
                                                       style="max-width: 520px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;width: 100%;"
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
                                             data-bgcolor="Bg White" data-color="Secondary" data-size="Text Default"
                                             data-min="12" data-max="20"
                                             style="font-family: helvetica Neue Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 15px;line-height: 25.5px;background-color: rgb(255, 255, 255);color: rgb(66, 70, 81);padding: 30px 40px 25px; border-left: solid 1px #E5E5E5; border-right: solid 1px #E5E5E5;">
                                             <h4 class="o_heading o_text-dark o_mb-xs" data-color="Dark"
                                                  data-size="Heading 4" data-min="10" data-max="26"
                                                  style="font-family: helvetica Neue Arial, sans-serif; font-weight: 500  ; margin-top: 0px; margin-bottom: 20px; color: rgb(36, 43, 61); font-size: 16px; line-height: 29px;">
                                                  Chào, {{$user->email}} </h4>
                                             <p
                                                  style="margin-top: 20px; margin-bottom:15px; font-weight: bold;font-size:24px;line-height: 29px;">
                                                  Chúc mừng bạn đã nâng cấp thành công!
                                             </p>
                                             <table style="text-align: left;font-size:15px; width: 100%; margin: 0">
                                                  <tbody>
                                                       <tr>
                                                       <th style="padding-bottom: 5px; font-weight: 400;">Loại user:</th>
                                                       <td style="padding-bottom: 5px; padding-left: 20%; text-align: right">{{ $user->planInfo->name }}</td>
                                                       </tr>
                                                       <tr>
                                                       <th style="font-weight: 400; padding-bottom: 5px;border-top:dashed 1px #eaeaea;; padding-top: 5px;">
                                                            Số tiền đã thanh toán:</th>
                                                       <td style="padding-bottom: 5px; padding-left: 20%;border-top:dashed 1px #eaeaea;; padding-top: 5px; text-align: right">
                                                            {{number_format($transaction->amount)}}đ</td>
                                                       </tr>
                                                       <tr>
                                                       <th style="font-weight: 400; padding-bottom: 5px; border-top:dashed 1px #eaeaea;; padding-top: 5px; ">
                                                            Ngày bắt đầu:
                                                       </th>
                                                       <td style="padding-bottom: 5px; padding-left: 20%;border-top:dashed 1px #eaeaea;; padding-top: 5px; text-align: right">
                                                            {{$transaction->activation->created_at}}
                                                       </td>
                                                       </tr>
                                                       <tr>
                                                       <th style="font-weight: 400; padding-bottom: 5px; border-top:dashed 1px #eaeaea;; padding-top: 5px;">
                                                            Ngày kết
                                                            thúc:</th>
                                                       <td style="border-top:dashed 1px #eaeaea;; padding-top: 5px; padding-bottom: 5px; padding-left: 20%; text-align: right">
                                                            {{$transaction->activation->expiration_date}}
                                                       </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                             <p style="color:#333333;font-size:14px;line-height: 20px;margin: 30px 0px 20px;">
                                                  Hãy bắt đầu hành trình SEO một cách cực thông minh, cực hiệu quả, cực năng
                                                  suất cùng Ren SEO nhé.
                                             </p>
                                             <a href="http://app.renseo.vn"
                                                  style="text-decoration: none;">
                                                  <button
                                                       style="cursor: pointer;background-image: linear-gradient(#268DFF, #007AFF); border:solid 1px rgba(0,0,0,0.1);box-shadow: 0px 0.5px 1px rgba(0,0,0,0.28); color: #ffffff;padding:10px 20px; border-radius: 5px; font-weight:500;font-size:15px">
                                                       Truy cập Ren SEO
                                                  </button>
                                             </a>
                                             <a href="https://renseo.vn/"
                                                  style="text-decoration: none;">
                                                  <button
                                                       style=" cursor: pointer; background: #ffffff;
                                        border:solid 1px rgba(0,0,0,0.1);box-shadow: 0px 0.5px 1px rgba(0,0,0,0.28);
                                        color:#262F3D; padding:10px 20px; border-radius: 5px; font-weight:500; font-size:15px">
                                                       Tìm hiểu thêm
                                                  </button>
                                             </a>
                                             <p style="color:#333333; font-size:14px;margin-bottom:0px; margin-top: 40px;">
                                                  Thân,<br>Ren SEO team
                                             </p>
                                             <p style="border-bottom: solid 1px #E5E5E5; padding-top: 40px; margin: 0px;">
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
@endsection