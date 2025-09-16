@props(['crew'])

@php
    // Group crew by position/department
    $groupedCrew = $crew->groupBy('pivot.position');

    // Define department mapping (German to display names)
    $departmentMap = [
        'Regie' => 'Regie',
        'Produktion' => 'Produktion',
        'Drehbuch' => 'Drehbuch',
        'Musik' => 'Musik',
        'Kamera' => 'Kamera',
        'Schnitt' => 'Schnitt',
    ];

    $departments = [];
    foreach($groupedCrew as $position => $people) {
        $department = $departmentMap[$position] ?? 'Sonstige';
        if (!isset($departments[$department])) {
            $departments[$department] = [];
        }
        foreach($people as $person) {
            $departments[$department][] = [
                'person' => $person,
                'name' => $person->name,
                'position' => $position
            ];
        }
    }

    // Define department order
    $departmentOrder = ['Regie', 'Produktion', 'Drehbuch', 'Musik', 'Kamera', 'Schnitt', 'Sonstige'];
    $orderedDepartments = [];
    foreach($departmentOrder as $dept) {
        if (isset($departments[$dept])) {
            $orderedDepartments[$dept] = $departments[$dept];
        }
    }
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-8">
    @foreach($orderedDepartments as $department => $people)
        @if($department !== 'Sonstige')
            <div class="space-y-1.5">
                <h3 class="text-white text-lg">
                    {{ $department }}
                </h3>

                <div class="space-y-3">
                    @foreach($people as $person)
                        <div class="space-y-1">
                            <a href="{{route('people.details', $person)}}" class="text-indigo-300 font-light hover:text-white block transition-colors duration-200">
                                {{ $person['name'] }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>

@if(isset($orderedDepartments['Sonstige']))
    <div class="pt-5">
        <h3 class="text-white text-lg mb-2.5">
            Sonstige
        </h3>

        <div class="grid grid-cols-2 gap-x-20 gap-y-3">
            @foreach($orderedDepartments['Sonstige'] as $person)
                <div class="grid grid-cols-2 gap-x-16 items-center">
                    <a href="{{route('people.details', $person)}}" class="text-indigo-300 font-light hover:text-white truncate pr-4 transition-colors duration-200">
                        {{ $person['name'] }}
                    </a>
                    <p class="text-sm mr-16 font-light">
                        {{ $person['position'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
@endif
