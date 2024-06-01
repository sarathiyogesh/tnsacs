<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Log;

class Priohub extends Model
{
    public $tourApiUrl;
    public $user_name;
    public $password;
    public $distributorId;
    public $token;

    public function __construct() {
        // $this->tourApiUrl = 'https://distributor-api.prioticket.com/v3.5/distributor/';
        // $this->distributorId = '47000';//env('PRIOHUB_DISTRIBUTOR_ID');
        // $this->user_name = 'Bookingbash&95Ui@prioapis.com';
        // $this->password = '5V^B9n3Q#T4Oas*X';
        // $this->token = '';
    }

    // public function __construct() {
    //     $this->tourApiUrl = 'https://sandbox-distributor-api.prioticket.com/v3.2/distributor/';
    //     $this->distributorId = '1070595';//env('PRIOHUB_DISTRIBUTOR_ID');
    //     $this->user_name = 'bookingbash-demo@prioapis.com';
    //     $this->password = 'S4*WCZu5#VOr4y2';
    //     $this->token = '';
    // }

    public function fetchToken() {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->tourApiUrl.'oauth2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "grant_type": "client_credentials",
                "scope": "https://www.prioticketapis.com/auth/distributor.booking"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic '. base64_encode("$this->user_name:$this->password")
            ),
        ));

        $response = curl_exec($curl);
        if($response === false){
            return 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
        $response = json_decode($response);
        if(isset($response->access_token)){
            return $response->access_token;
        }
        return '';
    }

    public function fetchProducts() {
        $this->token = $this->fetchToken();

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->tourApiUrl.'products/?distributor_id='.$this->distributorId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        if($response === false){
            return 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
        return $response;
    }

    public function fetchTour($product_id) {
        $this->token = $this->fetchToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->tourApiUrl.'products/'.$product_id.'?distributor_id='.$this->distributorId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        if($response === false){
            return 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
        return $response;
    }

    public function fetchAvailability($product_id, $date) {
        $this->token = $this->fetchToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->tourApiUrl.'products/'.$product_id.'/availability?distributor_id='.$this->distributorId.'&from_date='.$date,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        if($response === false){
            return 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
        return $response;
    }

    public function fetchReservation($reservation_no) {
        $this->token = $this->fetchToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->tourApiUrl.'reservations/'.$reservation_no,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        if($response === false){
            return 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
        return $response;
    }

    public function confirmReservation($payload) {
        $this->token = $this->fetchToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $this->tourApiUrl.'reservations',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($payload),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer '.$this->token
          ),
        ));

        $response = curl_exec($curl);

        if($response === false){
            return 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
        return $response;
    }

    public function confirmOrder($payload) {
        $this->token = $this->fetchToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $this->tourApiUrl.'orders',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($payload),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer '.$this->token
          ),
        ));

        $response = curl_exec($curl);
        Log::info('Priohub Confirm Ticket');
        Log::info($payload);
        Log::info($response);
        if($response === false){
            return 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
        return $response;
    }

    public function fetchTicketBooking($payload) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->tourApiUrl . 'bookings',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function getTicketBooking($payload) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->tourApiUrl . 'GetBookedTickets',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function getVoucher($reference_no) {
        $this->token = $this->fetchToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->tourApiUrl.'orders/'.$reference_no.'/voucher',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        if($response === false){
            return 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
        return $response;
    }

    public function getOrderDetails($reference_no) {
        $this->token = $this->fetchToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->tourApiUrl.'orders/'.$reference_no,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        if($response === false){
            return 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
        return $response;
    }
}
