New website enquiry

Name: {{ $enquiry['name'] }}
Email: {{ $enquiry['email'] }}
Company: {{ $enquiry['company'] ?? 'Not provided' }}
Project type: {{ $enquiry['projectType'] }}

Message:
{{ $enquiry['message'] }}
