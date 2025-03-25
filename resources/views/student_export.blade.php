<table>
    <thead>
        <tr>
            <td colspan="5" style="text-align: center; font-weight: bold;">ព្រះរាជាណាចក្រកម្ពុជា</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center; font-weight: bold;">ជាតិ សាសនា ព្រះមហាក្សត្រ</td>
        </tr>
        <tr>
            <td colspan="5" style="font-weight: bold;">ក្រសួងអប់រំ យុវជន និង កីឡា</td>
        </tr>
        <tr>
            <td colspan="5" style="font-weight: bold;">សាកលវិទ្យាល័យភូមិន្ទភ្នំពេញ</td>
        </tr>
        <tr>
            <td colspan="5" style="color: blue;">និស្សិត​ {{ $itClass['name'] }} ជំនាន់ទី {{ $generationName }} ឆ្នាំទី {{ $academicName}}</td>
        </tr>
    </thead>
</table>

<table>
    <thead>
        <tr>
            <th style="width: 50px;">No</th>
            <th style="width: 300px;">Student ID</th>
            <th style="width: 500px;">First Name</th>
            <th style="width: 500px;">Last Name</th>
            <th style="width: 300px;">Date of Birth</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $index => $student)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student['student_id']?? 'មិនមាន' }}</td>
                <td>{{ $student['first_name'] ?? 'មិនមាន'}}</td>
                <td>{{ $student['last_name']?? 'មិនមាន' }}</td>
                <td>{{ $student['date_of_birth'] ?? 'មិនមាន'}}</td>
            </tr>
        @endforeach
    </tbody>
</table>


