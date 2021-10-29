<div>
    <img src="{{ asset('assets/logo.png') }}" alt="IMG" style="height:200px;" >
    <h2>Greetings {{ $data['name'] }}! </h2>
	<p>Thank you for choosing PaysupGen as your Business Partner!</p>
	<p>To Start, Please verify your email by clicking or copying the link below.</p>
	<h3>Happy Earnings!!!.</h3><br><br>
	<h2><a href="http://paysupgen.ybfgen.com/registration/verify/{{ $data['key'] }}">http://paysupgen.ybfgen.com/registration/verify/{{ $data['key'] }}</a></h2>
</div>