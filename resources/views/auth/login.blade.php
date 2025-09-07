
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    @vite('resources/css/app.css') 
</head>
<body
  class="h-screen w-screen bg-cover bg-center relative"
  style="background-image: url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=1470&q=80');"
>
    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <!-- Centered Login Form -->
    <div class="relative z-10 flex items-center justify-center h-full">
        <div class="bg-white/10 backdrop-blur-md rounded-xl shadow-2xl p-8 w-full max-w-md text-white">
            <h2 class="text-3xl font-bold mb-6 text-center">Welcome Back</h2>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-500/90 text-white p-2 mb-4 rounded text-sm text-center">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('status'))
                <div class="bg-green-500/90 text-white p-2 mb-4 rounded text-sm text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- LOGIN FORM -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <label class="block text-sm font-semibold mb-1">Email address</label>
                <input
                    type="email"
                    name="email"
                    class="w-full px-4 py-3 mb-4 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="Enter your email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                />

                <!-- Password -->
                <label class="block text-sm font-semibold mb-1">Password</label>
                <input
                    type="password"
                    name="password"
                    class="w-full px-4 py-3 mb-2 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="Enter your password"
                    required
                />

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between mb-4 text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2" />
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-orange-400 hover:underline">Forgot password?</a>
                    @endif
                </div>

                <!-- Sign In Button -->
                <button
                    type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-full font-semibold transition mb-4"
                >
                    Sign In
                </button>
            </form>

            <!-- Sign Up Prompt -->
            <p class="text-center text-sm">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-orange-400 hover:underline">Sign up</a>
            </p>
        </div>
    </div>
</body>
</html>
