<?php

namespace App\Services;

use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Carbon;

class CommissionCalculatorService
{
    public static function calculateUserCommissionReport($startDate, $endDate, $userId)
    {
        // Converte as datas para o formato adequado
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate)->endOfDay();

        // Busca os serviços no intervalo de datas
        $services = Service::whereBetween('created_at', [$startDate, $endDate])
            ->where('user_id', $userId)
            ->where('is_paid', 1)
            ->get();

        // Se não houver serviços, retorna 0
        if ($services->isEmpty()) {
            return 0;
        }

        // Calcula a comissão total para o usuário
        $totalValue = $services->sum('price');
        $commissionPercentage = $services->first()->user->commission; // Assume que todos os serviços têm o mesmo usuário
        $totalCommission = $totalValue * ($commissionPercentage / 100);

        // dd($totalCommission);

        return [
            'services' => $services,
            'user' => $services->first()->user,
            'commission' => $totalCommission
        ];
    }

    public static function calculateUserCommission($userId, $serviceValue)
    {
        $user = User::findOrFail($userId);
        $percentCommission = $user->commission;

        return $serviceValue * ($percentCommission / 100);
    }
}
