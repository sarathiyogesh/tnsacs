<table width="600" cellspacing="0" cellpadding="0" border="1" align="center">
    <tbody>
        <tr>
            <td>
                <table width="600" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td valign="top" height="90" bgcolor="#fff" align="center">
                                <table width="529" cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td height="25"></td>
                                        </tr>
                                        <tr>
                                            <td align="left"><img width="280" height="68" src="{!! asset('frontend/images/logo.png') !!}"></td>
                                            <td style="font-family:Segoe UI,arial;font-style:normal;font-size:20px;font-weight:bold;color:#373536" align="right">Signup OTP</td>
                                        </tr>
                                        <tr>
                                            <td height="25"></td>
                                        </tr>
                                    </tbody> 
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td bgcolor="#F9F9F9" align="center">
                                <table width="529" cellspacing="0" cellpadding="0" border="0">

                                    <tbody>
                                        <tr>
                                            <td height="10">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:Segoe UI,arial;font-size:15px;color:#28374f;text-align:left">Dear <b>{!! $user->name !!}</b>,</td>
                                        </tr>
                                        <tr>
                                            <td height="10">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:Segoe UI,arial;font-size:15px;color:#28374f;text-align:left">Here is your signup OTP Code</td>
                                        </tr>
                                        <tr>
                                            <td height="10">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:Segoe UI,arial;font-size:22px;font-weight:800;color:#28374f;text-align:left;background-color: #ddd;padding: 5px 10px;display: inline-block;">{{ $user->email_otp }}</td>
                                        </tr>
                                        <tr>
                                            <td height="10">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:Segoe UI,arial;font-size:15px;color:#28374f;text-align:left">Please make sure you never share this code with anyone.</td>
                                        </tr>
                                        <tr> 
                                          <td style="font-family:Segoe UI,arial;font-size:15px;color:#28374f;text-align:left"><br>
                                          Best Regards,<br>
                                          <a href="{{ url('/') }}" target="_blank">TNSACS Team</a></td> 
                                        </tr>
                                        <tr>
                                            <td height="10">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="font-family:Tahoma,Geneva,sans-serif;font-size:11px;color:#666666;text-align:center;padding:10px;border-bottom:0" colspan="2" bgcolor="#fff"><strong>Follow us on</strong><br>
                <a href="javascript:;" target="_blank">Facebook</a> | <a href="javascript:;" target="_blank">Instagram</a> | <a href="javascript:;" target="_blank">Twitter</a>
            </td>
        </tr>
        <!-- <tr>
            <td style="font-family:Tahoma,Geneva,sans-serif;font-size:11px;color:#666666;text-align:center;padding:0 10px;border-top:0;border-bottom: 0" colspan="2" bgcolor="#fff">
                Email: 
            </td>
        </tr> -->
        <tr>
            <td style="font-family:Tahoma,Geneva,sans-serif;font-size:11px;color:#666666;text-align:center;padding:4px;border-top:0" colspan="2" bgcolor="#fff">© Copyright Tamil Nadu State AIDS Control Society. All rights reserved.</td>
        </tr>
    </tbody>
</table>