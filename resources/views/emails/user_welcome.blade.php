<table width="600" cellspacing="0" cellpadding="0" border="0" align="center">
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
                                            <td align="left"><img width="200" height="70" src="https://bookingbash.com/images/logo.png"></td>
                                            <td style="font-family:Segoe UI,arial;font-style:normal;font-size:20px;font-weight:bold;color:#008bd2" align="right">Registered Successfully!</td>
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
                                            <td style="font-family:Segoe UI,arial;font-size:15px;color:#28374f;text-align:left">Hello <b> {{ $user->name }}&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td height="10">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:Segoe UI,arial;font-size:15px;color:#28374f;text-align:left">You are successfully registered as an employee </b> at  <b>{!! env('APP_NAME') !!}</b>. Please find your Username and Password details below. <br>
                                            <b>
                                                Username : {{$user->email}}
                                                Password : {{$pass}}
                                            </b> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="10">&nbsp;</td>
                                        </tr>
                                        <tr> 
                                          <td style="font-family:Segoe UI,arial;font-size:15px;color:#28374f;text-align:left"><br>
                                          Regards,<br>
                                          Team - BGIKS Team</a></td> 
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
       
    </tbody>
</table>