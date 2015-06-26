<?php

namespace Snowflake;

use Closure;
use Snowflake\Http\Request;
use Snowflake\Http\Response;

class Snowflake 
{

    const VERSION = '0.0.1'; 

    protected $request;

    protected $routes = [];

    public function __construct() 
    {
        $this->request = new Request();
    }

    public function start() 
    {
        $response = $this->dispatch();

        if ($response === true) {
            Response::send(200);
        } else {
            Response::send(404);
            $this->getFourOFour();
        }

    }

    public function dispatch() 
    {
        $this->request->listen($_SERVER);

        $method = $this->request->getMethod();
        $uri = $this->request->getUri();
        
        $route = $method . $uri;

        return array_key_exists($route, $this->routes) ? true : false; 
    }

    public static function getFourOFour() 
    {
        ob_start();
        ?>
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8"/>
                    <title>Snowflake 404 Page</title>
                    <style>
                        html,body,div,span,object,iframe,
                        h1,h2,h3,h4,h5,h6,p,blockquote,pre,
                        abbr,address,cite,code,
                        del,dfn,em,img,ins,kbd,q,samp,
                        small,strong,sub,sup,var,
                        b,i,
                        dl,dt,dd,ol,ul,li,
                        fieldset,form,label,legend,
                        table,caption,tbody,tfoot,thead,tr,th,td,
                        article,aside,canvas,details,figcaption,figure,
                        footer,header,hgroup,menu,nav,section,summary,
                        time,mark,audio,video{margin:0;padding:0;border:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent;}
                        body{line-height:1;}
                        article,aside,details,figcaption,figure,
                        footer,header,hgroup,menu,nav,section{display:block;}
                        nav ul{list-style:none;}
                        blockquote,q{quotes:none;}
                        blockquote:before,blockquote:after,
                        q:before,q:after{content:'';content:none;}
                        a{margin:0;padding:0;font-size:100%;vertical-align:baseline;background:transparent;}
                        ins{background-color:#ff9;color:#000;text-decoration:none;}
                        mark{background-color:#ff9;color:#000;font-style:italic;font-weight:bold;}
                        del{text-decoration:line-through;}
                        abbr[title],dfn[title]{border-bottom:1px dotted;cursor:help;}
                        table{border-collapse:collapse;border-spacing:0;}
                        hr{display:block;height:1px;border:0;border-top:1px solid #cccccc;margin:1em 0;padding:0;}
                        input,select{vertical-align:middle;}
                        html{ background: #EDEDED; height: 100%; }
                        body{background:#FFF;margin:0 auto;min-height:100%;padding:0 30px;width:440px;color:#666;font:14px/23px Arial,Verdana,sans-serif;}
                        h1,h2,h3,p,ul,ol,form,section{margin:0 0 20px 0;}
                        h1{color:#333;font-size:20px;}
                        h2,h3{color:#333;font-size:14px;}
                        h3{margin:0;font-size:12px;font-weight:bold;}
                        ul,ol{list-style-position:inside;color:#999;}
                        ul{list-style-type:square;}
                        code,kbd{background:#EEE;border:1px solid #DDD;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:0 4px;color:#666;font-size:12px;}
                        pre{background:#EEE;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:5px 10px;color:#666;font-size:12px;}
                        pre code{background:transparent;border:none;padding:0;}
                        a{color:#70a23e;}
                        header{padding: 30px 0;text-align:center;}
                    </style>
                </head>
                <body>
                <h1>404</h1>
                <h3>The Requested Route Cloud Not Be Found!</h3>
                </body>
            </html>
        <?php    
        return ob_end_flush();
    }

    public function get($uri, $settings = [], Closure $callback) 
    {
        $this->addRoute('GET', $uri, $settings);

        return $this;
    }

    public function post($uri, $settings = [], Closure $callback) 
    {
        $this->addRoute('POST', $uri, $settings);

        return $this;
    }

    public function put($uri, $settings = [], Closure $callback) 
    {
        $this->addRoute('PUT', $uri, $settings);

        return $this;
    }
    
    public function delete($uri, $settings = [], Closure $callback) 
    {
        $this->addRoute('DELETE', $uri, $settings);

        return $this;
    }        

    protected function addRoute($method, $uri, $settings = [])
    {
        $this->routes[$method.$uri] = ['method' => $method, 'uri' => $uri, 'settings' => $settings];
    }

}
