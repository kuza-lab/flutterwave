<?php


/**
 * Settlement
 * @author Phelix Juma <jumaphelix@kuzalab.com>
 * @copyright (c) 2020, Kuza Lab
 * @package Kuzalab
 */

namespace Phelix\Flutterwave;


final class Settlement {

    /**
     * @var Flutterwave
     */
    protected $flutterwave;

    /**
     * Settlement constructor.
     * @param Flutterwave $flutterwave
     */
    public function __construct(Flutterwave $flutterwave) {
        $this->flutterwave = $flutterwave;
    }

    /**
     * Get all settlements
     *
     * @param int $page This is the page number to retrieve e.g. setting 1 retrieves the first page
     * @return mixed
     */
    public function getSettlements($page = null) {

        $query_params = [];

        if (!is_null($page)) {
            $query_params['page'] = $page;
        }

        $response = $this->flutterwave->request->request("get", "settlements", $this->flutterwave->token, null, $query_params);

        return $response->responseBody;
    }

    /**
     * Get details of one specific settlement
     *
     * @param $id
     * @param string $from The start date range to retrieve data from. YYYY:MM:DD
     * @param string $to The end date range to retrieve data. YYYY:MM:DD
     * @return mixed
     */
    public function getOneSettlement($id, $from=null, $to=null) {

        $query_params = [];

        if (!is_null($from)) {
            $query_params['from'] = $from;
        }
        if (!is_null($to)) {
            $query_params['to'] = $to;
        }

        $response = $this->flutterwave->request->request("get", "settlements/$id", $this->flutterwave->token, null, $query_params);

        return $response->responseBody;
    }


}