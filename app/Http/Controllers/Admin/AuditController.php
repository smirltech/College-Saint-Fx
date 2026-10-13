<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Audit;

class AuditController extends Controller
{
    // display all audits, using the Audit facade and passing the model to the view, paginated
    public function index()
    {
        $audits = Audit::with('user')->latest()->get();


        $heads = [
            'Utilisateur',
            'Evenement',
            'Table',

            'Date',
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $data = [];
        foreach ($audits as $audit) {

            $btnDetails = '<a href="' . route('audits.show', $audit) . '" class="btn btn-xs btn-default mx-1 shadow-sm" title="Details">
                   <i class="fa fa-eye"></i>
               </a>';

            $data[] = [
                "{$audit->user->email}",
                '<span class="badge bg-' . $audit->event->variant() . '">' . $audit->event->label() . '</span>',

                "{$audit->display_auditable}",


                $audit->display_date,
                '<nobr>' . $btnDetails . '</nobr>',
            ];
        }


        $config = [
            'data' => $data,
            'order' => [],
            'columns' => [null, null, null, null, ['orderable' => false]],
        ];

        $title = 'Audit Log';


        return view('audits.index', compact('heads', 'config', 'title'));
    }

    // display a single audit
    public function show(Audit $audit)
    {
        return view('audits.show', compact('audit'));
    }

}
