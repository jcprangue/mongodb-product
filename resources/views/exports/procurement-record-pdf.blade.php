<!DOCTYPE html>
<html lang='en'>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link type='text/css' href='css/app.css' rel='stylesheet'>
    <link type='text/css' href='css/print.css' rel='stylesheet' media="print">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" integrity="sha512-wnea99uKIC3TJF7v4eKk4Y+lMz2Mklv18+r4na2Gn1abDRPPOeef95xTzdwGD9e6zXJBteMIhZ1+68QC5byJZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @media print {
            .bg-yellow-300 {
                background-color: #fcd34d !important;
            }
        }

        @page {
            margin: 5px;
        }

        .bg-yellow-300 {
            background-color: #fcd34d !important;
            font-weight: 500;
        }

        .padding-lr {
            padding-left: 5px;
            padding-right: 5px;
        }

        body {
            margin: 5px;
        }
    </style>
</head>

<body class="">
    <main style="font-size:10px">
        <div>
            <table class='w-full whitespace-no-wrap bg-white'>
                <tbody class='text-center line'>
                    <tr>
                        <td class="w-3/12" rowspan="6">
                            <!-- <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIhzn68g2OhhW7n3qSgH4Ix7NYL1qW5hhrWAO5sn-tRD2R6cGSN9hx5euEmvZQzt99OB4&usqp=CAU" width="100" height="100" /> -->
                        </td>
                        <td class="h-4"></td>
                        <td class="w-3/12" rowspan="6"></td>
                    </tr>
                    <tr>
                        <td class="w-6/12 leading-none">Republic of the Philippines</td>
                    </tr>
                    <tr>
                        <td class="leading-none">Province of Oriental Mindoro</td>
                    </tr>
                    <tr>
                        <td class="leading-none">City of Calapan</td>
                    </tr>
                    <tr>
                        <td class="text-xl font-bold leading-none">Bids and Awards Committee</td>
                    </tr>
                    <tr>
                        <td class="h-4"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div>
            <label class="float-left">List of Records</label>
            <label class="float-right">Total Records : {{$values["count"]}}</label>
            <br>
            <table class='w-full whitespace-no-wrap bg-white'>
                <thead class='bg-gray-200 border border-black '>
                    <tr class='border'>
                        <td class='px-2 bg-yellow-300 text-white border border-black '>#</td>
                        <td class='px-2 bg-yellow-300 text-white border border-black w-32'>Bid Opening Date</td>
                        <td class='px-2 bg-yellow-300 text-white border border-black w-32'>IB Number</td>
                        <td class='px-2 bg-yellow-300 text-white border border-black '>Project Name</td>
                        <td class='px-2 bg-yellow-300 text-white border border-black '>Contractor</td>
                        <!-- <td class='px-2 bg-yellow-300 text-white border border-black '>Category</td> -->
                        <td class='px-2 bg-yellow-300 text-white border border-black w-32''>Office</td>
                        <!-- <td class=' px-2 bg-yellow-300 text-white border border-black '>LGU</td> -->
                        <!-- <td class=' px-2 bg-yellow-300 text-white border border-black '>Barangay</td> -->
                        <td class=' px-2 bg-yellow-300 text-white border border-black '>Amount</td>
                        <td class=' px-2 bg-yellow-300 text-white border border-black '>Status</td>
                        <td class=' px-2 bg-yellow-300 text-white border border-black '>Remarks</td>
                    </tr>


                </thead>



                <tbody class=' border border-black '>
                    @php $counter = 0; @endphp
                    @foreach($procurement_records as $procurement)

                    @php $counter++; @endphp
                    <tr class=' bg-orange-400'>
                        <td class='border border-black padding-lr'>{{$counter}}</td>
                        <td class='border border-black padding-lr'>{{$procurement->bid_opening_date}}</td>
                        <td class='border border-black padding-lr'>{{$procurement->ib_number}}</td>
                        <td class='border border-black padding-lr'>{{$procurement->project_name}}</td>
                        <td class='border border-black padding-lr'>{{$procurement->contractor}}</td>
                        <!-- <td class='border border-black padding-lr'>{{$procurement->category->name ?? ""}}</td> -->
                        <td class='border border-black padding-lr'>{{$procurement->office->name ?? ""}}</td>
                        <!-- <td class='border border-black padding-lr'>{{$procurement->lgu->lgus ?? ""}}</td> -->
                        <!-- <td class='border border-black padding-lr'>{{$procurement->barangay->brgyDesc ?? ""}}</td> -->
                        <td class='border border-black padding-lr'>{{$procurement->amount}}</td>
                        <td class='border border-black padding-lr'>{{$procurement->status}}</td>
                        <td class='border border-black padding-lr'>{{$procurement->remarks}}</td>
                    </tr>
                    @endforeach

                    </tbody>
            </table>
        </div>


        <div class="flex mt-8">
            <table class="w-full">
                <tr>
                    <td class="w-64">
                        <div class="mb-10">
                            Prepared by:
                        </div>
                        <div class="font-bold">
                            {{ strtoupper(Auth::user()->name) }}
                        </div>
                        <div>
                            {{ Auth::user()->position }}
                        </div>
                        <div class="">
                            <span>Date:</span>
                            <span class="font-mono underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </div>
                    </td>
                    @foreach ($values['signatory'] as $signatory)
                    <td class="w-64">
                        <div class="mb-10">
                            @if ($signatory->is_visible == 1)
                            Noted By:
                            @else
                            Approved By:
                            @endif
                        </div>
                        <div class="font-bold">
                            {{ $signatory->name }}
                        </div>
                        <div>
                            {{ $signatory->position }}
                        </div>
                        <div class="">
                            <span">Date:</span>
                                <span class="font-mono underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </div>
                    </td>
                    @endforeach

                </tr>
            </table>
        </div>
    </main>
</body>

</html>