<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PropertyAnalytic;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;

class PropertyAnalyticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array_merge($request->all(), $request->route()->parameters);
        $validator = $this->getValidator($data);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $newAnalytic = new PropertyAnalytic();
        $newAnalytic->analytic_type_id = $data['analytic_type_id'];
        $newAnalytic->property_id = $data['property_id'];
        $newAnalytic->value = $data['value'];

        $newAnalytic->save();

        return $newAnalytic;

    }

    public function showByProperty(Request $request)
    {
        $propertyId = $request->route('property_id');
        $result = PropertyAnalytic::where([
            'property_id' => $propertyId
        ])->get();
        return $result;

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\PropertyAnalytic $propertyAnalytic
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyAnalytic $propertyAnalytic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PropertyAnalytic $propertyAnalytic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyAnalytic $propertyAnalytic)
    {
        $data = array_merge($request->all(), $request->route()->parameters);
        $validator = $this->getValidator($data);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $analytic = PropertyAnalytic::where(
                ['property_id' => $data['property_id'],
                    'id' => $data['id']
                ]
            )->firstOrFail();
            $analytic->update($data);
            return $analytic;

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }


    }

    protected function getValidator($data)
    {
        $validator = \Validator::make($data, [
            'analytic_type_id' => 'required|integer',
            'property_id' => 'required|integer',
            'value' => 'required',
        ]);
        return $validator;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\PropertyAnalytic $propertyAnalytic
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyAnalytic $propertyAnalytic)
    {
        //
    }

    public function summary(Request $request)
    {
        $analytics = DB::table('properties')
            ->select(['value', 'properties.id', 'property_id'])
            ->leftJoin('property_analytics', 'properties.id', '=', 'property_analytics.property_id');

        $suburb = $request->query('suburb');
        $state = $request->query('state');
        $country = $request->query('country');
        if (!empty($suburb)) {
            $analytics->where('suburb', '=', $suburb);
        }
        if (!empty($state)) {
            $analytics->where('state', '=', $state);
        }
        if (!empty($country)) {
            $analytics->where('country', '=', $country);
        }

        $collection = $analytics->get();
        $median = $collection->median('value');
        $max = $collection->max('value');
        $min = $collection->min('value');

        $propertyTotal = $collection->unique('id')->count();
        $propertyNullValueTotal = $collection->unique('id')->filter(function($item){
            return ($item->value === null);
        })->count();

        return response()->json([
            'min' => +$min,
            'max' => +$max,
            'median' => +$median,
            'properties_with_value_percentage' => (1-$propertyNullValueTotal/$propertyTotal) * 100,
            'properties_without_value_percentage' => ($propertyNullValueTotal/$propertyTotal) * 100,
        ]);


    }


}
