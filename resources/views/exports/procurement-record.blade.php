<table>
    <thead>
        <tr>
            <td rowspan="2">#</td>
            <td rowspan="2">Bid Opening Date</td>
            <td rowspan="2">IB Number</td>
            <td rowspan="2">Project Name</td>
            <td rowspan="2">Contractor</td>
            <td rowspan="2">Category</td>
            <td rowspan="2">Office</td>
            <td rowspan="2">LGU</td>
            <td rowspan="2">Barangay</td>
            <td rowspan="2">Amount</td>
            <td rowspan="2">Status</td>
            <td rowspan="2">Remarks</td>

            @foreach($category->documents as $document)
            @php
            $countField = count($document->fields);
            @endphp
            <td colspan="{{$countField}}">{{$document->document->name}}</td>
            @endforeach
        </tr>
        <tr>
            @foreach($category->documents as $document)
            @foreach($document->fields as $field)
            <td>{{$field->field_name}}</td>
            @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php $counter = 0; @endphp
        @foreach($procurements as $procurement)

        @php $counter++; @endphp
        <tr>
            <td>{{$counter}}</td>
            <td>{{$procurement->bid_opening_date}}</td>
            <td>{{$procurement->ib_number}}</td>
            <td>{{$procurement->project_name}}</td>
            <td>{{$procurement->contractor}}</td>
            <td>{{$procurement->category->name ?? ""}}</td>
            <td>{{$procurement->office->name ?? ""}}</td>
            <td>{{$procurement->lgu->lgus ?? ""}}</td>
            <td>{{$procurement->barangay->brgyDesc ?? ""}}</td>
            <td>{{$procurement->amount}}</td>
            <td>{{$procurement->status}}</td>
            <td>{{$procurement->remarks}}</td>
            <!-- 
            @foreach($procurement->details as $detail)
            @foreach($category->documents as $document)
            @foreach($document->fields as $field)
            @if ($detail->document_id == $document->id && $detail->field_id == $field->id)
            <td>{{$detail->data}}</td>
            @endif
            @endforeach
            @endforeach
            @endforeach -->
        </tr>
        @endforeach
    </tbody>
</table>