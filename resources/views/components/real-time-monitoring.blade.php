<div>
    <h2 class="text-lg font-bold text-center mb-2 text-[#28a8e0]">Monitoring Real-Time</h2>
    <div class="grid grid-cols-4 gap-2">

        @php
        $cards = [
            ['title' => 'Fire Alarm', 'value' => '-', 'unit' => '', 'status' => 'NORMAL', 'icon' => 'M12 11c0-1.657-1.343-3-3-3s-3 1.343-3 3c0 1.657 3 4.5 3 4.5s3-2.843 3-4.5zM12 11V3M9 21h6 M17.657 16.657L19.07 18.07M4.93 18.07l1.414-1.414M12 21v-3'],
            ['title' => 'Kelembapan', 'value' => '65', 'unit' => '%', 'status' => 'NORMAL', 'icon' => 'M7.456 16.223c2.336 2.336 6.145 2.336 8.481 0 2.336-2.336 2.336-6.145 0-8.481C14.793 6.6 12 4 12 4s-2.793 2.6-3.937 3.742c-2.336 2.336-2.336 6.145 0 8.481z'],
            ['title' => 'Suhu', 'value' => '28', 'unit' => '°C', 'status' => 'NORMAL', 'icon' => 'M12 13.5V3m0 0a3.5 3.5 0 100 7 3.5 3.5 0 000-7zM8.5 19h7a2.5 2.5 0 010 5h-7a2.5 2.5 0 010-5z'],
            ['title' => 'Kualitas Udara', 'value' => 'BAIK', 'unit' => '', 'status' => 'NORMAL', 'icon' => 'M3.5 16.5c2.4-3.2 6.4-3.2 8.8 0m-4.4-4.4c1.2-1.6 3.2-1.6 4.4 0M12 6.5c.6-.8 1.6-.8 2.2 0M5 12h14'],
            ['title' => 'Kebisingan', 'value' => '72', 'unit' => 'dB', 'status' => 'PERINGATAN', 'icon' => 'M11.996 4.002v16m-4-12v8m8-10v4m-12-2v4m16-6v8'],
            ['title' => 'Tekanan Gas', 'value' => '1.2', 'unit' => 'Bar', 'status' => 'NORMAL', 'icon' => 'M12 12a5 5 0 100-10 5 5 0 000 10zm0 0v6m-4-3h8 M19.071 4.929a9.948 9.948 0 010 14.142m-14.142 0a9.948 9.948 0 010-14.142'],
            ['title' => 'Emergency Exit', 'value' => 'AKTIF', 'unit' => '', 'status' => 'AKTIF', 'icon' => 'M15.25 8.25V6.5a2.25 2.25 0 00-2.25-2.25H6.5A2.25 2.25 0 004.25 6.5v11A2.25 2.25 0 006.5 19.75h6.5a2.25 2.25 0 002.25-2.25V15.75m-3-4.5h8.5m0 0l-3-3m3 3l-3 3'],
            ['title' => 'APD Tersedia', 'value' => '95', 'unit' => '%', 'status' => 'NORMAL', 'icon' => 'M8 7V5a4 4 0 118 0v2m-3.996 3.004A4.002 4.002 0 0112 7m0 0v3m0 0a2 2 0 012 2v5a2 2 0 01-2 2H8a2 2 0 01-2-2v-5a2 2 0 012-2m6-3h3.5a1.5 1.5 0 011.5 1.5V18a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 012 18V9.5A1.5 1.5 0 013.5 8H7'],
        ];
        @endphp

        @foreach ($cards as $card)
            @php
                $isWarning = $card['status'] === 'PERINGATAN';
                $isNormal = $card['status'] === 'NORMAL';
                $isActive = $card['status'] === 'AKTIF';

                $animationClass = $isWarning ? 'animate-pulse-warning' : '';
                $bgColor = 'bg-white';
                $borderColor = $isWarning ? 'border-yellow-400' : 'border-gray-200';

                $badgeBg = 'bg-gray-200';
                $badgeText = 'text-gray-800';
                if ($isWarning) {
                    $badgeBg = 'bg-yellow-200';
                    $badgeText = 'text-yellow-800';
                } elseif ($isActive) {
                    $badgeBg = 'bg-green-200';
                    $badgeText = 'text-green-800';
                } elseif ($isNormal) {
                    $badgeBg = 'bg-blue-200';
                    $badgeText = 'text-blue-800';
                }
                
                $iconBg = 'bg-gray-100';
                $iconText = 'text-gray-600';
                 if ($isWarning) {
                    $iconBg = 'bg-yellow-100';
                    $iconText = 'text-yellow-600';
                } elseif ($isActive) {
                    $iconBg = 'bg-green-100';
                    $iconText = 'text-green-600';
                } elseif ($isNormal) {
                    $iconBg = 'bg-blue-100';
                    $iconText = 'text-blue-600';
                }

            @endphp
            <div class="{{ $bgColor }} p-2 rounded-lg shadow-md flex flex-col justify-between border {{ $borderColor }} {{ $animationClass }}">
                <div>
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-2">
                            <div class="{{$iconBg}} p-1.5 rounded-md">
                                <svg class="w-5 h-5 {{$iconText}}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{$card['icon']}}"></path></svg>
                            </div>
                            <h3 class="font-semibold text-gray-700">{{ $card['title'] }}</h3>
                        </div>
                         <span class="text-xs font-bold {{$badgeBg}} {{$badgeText}} px-2 py-1 rounded-full">{{$card['status']}}</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-800 text-center mt-2">
                        {{ $card['value'] }}<span class="text-xl font-semibold text-gray-500">{{ $card['unit'] }}</span>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>

