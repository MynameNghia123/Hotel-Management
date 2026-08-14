<?php

namespace App\Http\Controllers;

use App\Helpers\TimeHelper;
use App\Services\Contracts\SurchargePolicyServiceInterface;
use App\Services\Contracts\SystemSettingServiceInterface;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    protected $systemSettingService;

    protected $surchargePolicyService;

    public function __construct(
        SystemSettingServiceInterface $systemSettingService,
        SurchargePolicyServiceInterface $surchargePolicyService
    ) {
        $this->systemSettingService = $systemSettingService;
        $this->surchargePolicyService = $surchargePolicyService;
    }

    public function index(Request $request)
    {
        $type = $request->query('type', 'general');

        $data = [];

        if ($type === 'general') {
            $data = [
                'check_in_time' => $this->systemSettingService->getCheckInTime(),
                'check_out_time' => $this->systemSettingService->getCheckOutTime(),
                'round_minutes' => $this->systemSettingService->getRoundMinutes(),
            ];
        } elseif ($type === 'surcharges') {
            $data = [
                'early_checkin_policies' => $this->surchargePolicyService->getEarlyCheckinPolicies(),
                'late_checkout_policies' => $this->surchargePolicyService->getLateCheckoutPolicies(),
            ];
        }

        return view('admin.configuration.index', compact('data', 'type'));
    }

    public function updateGeneralSettings(Request $request)
    {
        $validated = $request->validate([
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'round_minutes' => 'required|integer|min:0|max:59',
        ]);

        try {
            $this->systemSettingService->updateGeneralSettings($validated);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật cấu hình chung thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật cấu hình: '.$e->getMessage(),
            ], 500);
        }
    }

    public function updateSurchargePolicies(Request $request)
    {
        $validated = $request->validate([
            'early_checkin_policies' => 'required|array',
            'early_checkin_policies.*.hour_mark' => 'required|string',
            'early_checkin_policies.*.price' => 'required|numeric|min:0',
            'late_checkout_policies' => 'required|array',
            'late_checkout_policies.*.hour_mark' => 'required|string',
            'late_checkout_policies.*.price' => 'required|numeric|min:0',
        ]);

        try {
            // Convert hour_mark from "1h30p" format to decimal (1.5)
            $validated['early_checkin_policies'] = array_map(function ($policy) {
                return [
                    'hour_mark' => TimeHelper::parseHourMark($policy['hour_mark']),
                    'price' => $policy['price'],
                ];
            }, $validated['early_checkin_policies']);

            $validated['late_checkout_policies'] = array_map(function ($policy) {
                return [
                    'hour_mark' => TimeHelper::parseHourMark($policy['hour_mark']),
                    'price' => $policy['price'],
                ];
            }, $validated['late_checkout_policies']);

            $this->surchargePolicyService->updateSurchargePolicies($validated);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật quy định phụ phí thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật phụ phí: '.$e->getMessage(),
            ], 500);
        }
    }
}
