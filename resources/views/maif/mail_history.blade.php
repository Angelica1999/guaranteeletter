<form>
    <div class="table-container">
        <table class="table table-bordered">
            <thead>
                <tr>
                <th scope="col">Patient</th>
                <th scope="col">Modified By</th>
                <th scope="col">Sent By</th>
                <th scope="col">On</th>
                </tr>
            </thead>
            <tbody id="mail_history"></tbody>
                @foreach($history as $his)
                    <tr>
                        <td>{{ $his->patient->lname }}, {{ $his->patient->fname }} {{ $his->patient->mname }}</td>
                        <td>{{ $his->modified->lname }}, {{ $his->modified->fname }} {{ $his->modified->mname }}</td>
                        <td>{{ $his->sent->lname }}, {{ $his->sent->fname }} {{ $his->sent->mname }}</td>
                        <td>{{date('F j, Y', strtotime($his->created_at))}}</td>
                    </tr>
                @endforeach
        </table>
    </div>
</form>
