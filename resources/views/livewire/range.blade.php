<div>
    @if($result_type == "number")
        <livewire:numeric-range :$age_gender_group_id />
    @elseif($result_type == "text")
        <livewire:text-range :$age_gender_group_id />
    @elseif($result_type == "multiple_choice")
        <livewire:choice-range :$age_gender_group_id />
    @endif
</div>
