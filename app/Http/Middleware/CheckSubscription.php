<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est connecté et a un abonnement valide
        if ($user && $user->hasValidSubscription()) {
            return $next($request);
        }

        // Rediriger avec un message d'erreur si l'abonnement est invalide ou absent
        return redirect()->route('home')->withErrors(['message' => 'Vous devez avoir un abonnement valide pour accéder à cette page.']);
    }
}
