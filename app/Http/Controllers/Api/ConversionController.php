<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversion;
use App\Http\Resources\ConversionCollection;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Services\RomanNumeralConverter;

/**
 * Class ConversionController
 * @package App\Http\Controllers\API
 * @author Kashif <kash@dreamsites.co.uk>
 * @created 09/12/2020
 */
class ConversionController extends Controller
{

    /**
     * @var RomanNumeralConverter
     */
    private $romanNumberalConverter;

    /**
     * ConversionController constructor.
     * @param RomanNumeralConverter $romanNumberalConverter
     */
    public function __construct(RomanNumeralConverter $romanNumberalConverter)
    {
        $this->romanNumberalConverter = $romanNumberalConverter;
    }

    /**
     * To test a conversion and not persist
     * @param int $number
     * @return \Illuminate\Http\JsonResponse
     */
    public function displayConversion(int $number)
    {
        $validator = Validator::make(['number' => $number],
            [
                'number' => 'required|integer|between:1,3999'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 500);
        }

        return response()->json(['number' => $validator->valid()['number'], 'roman' => $this->romanNumberalConverter->convertInteger($number)]);
    }

    /**
     * @param int $number
     * @return \Illuminate\Http\JsonResponse
     */
    public function convert(int $number)
    {
        $validator = Validator::make(['number' => $number],
            [
                'number' => 'required|integer|between:1,3999'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 500);
        }

        try {
            $roman = $this->romanNumberalConverter->convertInteger($validator->valid()['number']);

            $conversion = Conversion::create([
                'number' => $validator->valid()['number'],
                'roman' => $roman
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(['conversion' => $conversion], 200);
    }

    /**
     * Display list of conversions with pagination
     * @return ConversionCollection
     */
    public function displayConversionList()
    {
        return new ConversionCollection(Conversion::orderBy('created_at', 'DESC')->paginate(10));
    }

    /**
     * Display list of Top Ten conversions
     * @return ConversionCollection
     */
    public function displayTopTen()
    {
        try {
            $conversions = DB::table('conversions')
                ->select(DB::raw('count(*) as number_count, number'))
                ->groupBy('number')
                ->take(10)
                ->orderBy(\DB::raw('count(number)'), 'DESC')
                ->get();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['conversions' => $conversions], 200);
    }
}
