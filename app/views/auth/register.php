<?php
$token = \App\Core\Session::csrfToken();
?>
<div class="bg-white p-6 rounded shadow">
<h2 class="text-xl font-semibold mb-4">Register</h2>
<form method="post" action="/register" class="space-y-3">
<input type="hidden" name="_csrf" value="<?= $token ?>">
<div>
<label class="block text-sm">Name</label>
<input name="name" class="mt-1 w-full rounded border px-2 py-1" />
</div>
<div>
<label class="block text-sm">Email</label>
<input name="email" class="mt-1 w-full rounded border px-2 py-1" />
</div>
<div>
<label class="block text-sm">Password</label>
<input name="password" type="password" class="mt-1 w-full rounded
border px-2 py-1" />
</div>
<div>
<label class="block text-sm">Confirm Password</label>
<input name="password2" type="password" class="mt-1 w-full rounded
border px-2 py-1" />
</div>
<div>
<button class="px-4 py-2 rounded bg-blue-600 text-white">Create
account</button>
<a href="/login" class="ml-2 text-sm text-blue-600">Login</a>
</div>
</form>
</div>