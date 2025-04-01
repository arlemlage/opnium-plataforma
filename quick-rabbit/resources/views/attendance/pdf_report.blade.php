<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ $title ?? "Attendance Report" }}</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/pdf_css/attendance_pdf.css?var=2.2') }}">
    </head>
    <body>
        <p class="text-center">
            <span><b>{{ "Attendance Report" }}</b></span><br>
            For: {{ isset($user) ? $user->full_name : "All" }}
            <br>
            Date:
            @if(isset($from_date) && isset($to_date))
                {{ $from_date.' to '.$to_date }}
            @elseif(isset($from_date) || isset($to_date))
                {{ $from_date ?? $to_date ?? "" }}
            @else
                {{ "All" }}
            @endif
            <br>
        </p>
        <table>
            <thead>
                <tr>
                    <th class="left nowrap">Employee</th>
                    <th class="left nowrap">In Time</th>
                    <th class="left nowrap">Out Time</th>
                    <th class="left nowrap">Work Hour</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $data)
                    <tr>
                        <td class="left nowrap">
                            {{ $data->user->full_name }}
                        </td>
                        <td class="left nowrap">
                            {{ $data->in_time ?? "N/A" }}
                        </td>
                        <td class="left nowrap">
                            {{ $data->out_time ?? "N/A" }}
                        </td>
                        <td class="left nowrap">
                            {{ $data->display_hours ?? "N/A" }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
