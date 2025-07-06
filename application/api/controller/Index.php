<?php

namespace app\api\controller;

use app\common\controller\Api;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    public function index()
    {
        $this->success('请求成功');
    }

    public function config()
    {
        //从refer中拿domain
        $refer = $this->request->server('HTTP_REFERER');
        $domain = parse_url($refer, PHP_URL_HOST);
        $domain = trim($domain);
        $domain = strtolower($domain);
        $domain_model = new \app\admin\model\Domain();
        $domain_info = $domain_model->where('domain', $domain)->find();
        if (!$domain_info) {
            $this->error('域名不存在');
        }
        $this->success('ok', [
            'is_openModal' => $domain_info->modal_switch,
            'is_trans' => $domain_info->tran_switch,
            'is_advertise'=> $domain_info->ad_switch,
            'modal_html'=> config('site.modal_html'),
            'trans_url'=> config('site.trans_url'),
            'advertise_html'=> config('site.ad_html'),
        ]);
    }
}
