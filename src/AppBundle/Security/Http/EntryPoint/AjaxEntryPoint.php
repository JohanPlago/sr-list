<?php
/**
 * An entry point for the ajax requests etc
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\Security\Http\EntryPoint;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\FormAuthenticationEntryPoint;

class AjaxEntryPoint extends FormAuthenticationEntryPoint
{
    public function start(Request $request, AuthenticationException $authException = null)
    {
        if ($request->isXmlHttpRequest()) {
            return new Response('', Response::HTTP_UNAUTHORIZED);
        } else {
            return parent::start($request, $authException);
        }
    }

}
