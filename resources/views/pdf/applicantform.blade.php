@extends('layout.pdf_header')

<div class="header">
    <div class="first-page-header"></div>
    <div class="title">
        <h1>Startfeld</h1>
    </div>
    @foreach ($applicant as $applied)
        <div>
            <span>Applicant Name:</span>
            <span>{{ $applied->firstname . ' ' . $applied->surname }}</span>
        </div>
        <div>
            <span>Applicant Date:</span>
            <span>{{ $applied->applicationStatus->created_at }}</span>
        </div>
        <div>
            <span>Applicant Name:</span>
            <span>{{ $applied->applicationStatus->status }}</span>
        </div>
    @endforeach
</div>
<div class="page-break"></div>
<div class="question-paper">
    <div class="question-answer">
        @foreach ($questions as $key => $question)
            <div class="question-answer-all">
                @if ($question->answer_type === 'title')
                    <div class="section-title">
                        @if ($key > 1 && $question->title['value'] !== 'Attachments')
                            <div class="page-break"></div>
                        @endif
                        @if ($question->title['value'] !== 'Attachments')
                            <h2><b>{{ $question->title['value'] }}</b></h2>
                        @endif
                        @if ($question->description)
                            <b>{{ $question->description['value'] }}</b>
                        @endif
                    </div>
                @elseif (
                    !$question->is_hidden &&
                        $question->answer_type !== 'key' &&
                        $question->answer_type !== 'title' &&
                        $question->answer_type !== 'file')
                    <div>
                        <h2><b>Q: {{ $question->title['value'] }}</b></h2>
                        @if ($question->description)
                            <b>{{ $question->description['value'] }}</b>
                        @endif
                    </div>
                    <div>
                        @if ($question->answerquestion && $question->answer_type !== 'date')
                            <p>Answer: {{ $question->answerquestion->value }}</p>
                        @elseif($question->answerquestion && $question->answer_type === 'date')
                            <p>Answer: {{ date('d.m.Y', strtotime($question->answerquestion->value)) }}
                        @else
                            <p>Answer: -</p>
                        @endif
                    </div>
                @elseif ($question->answer_type === 'file' && !$question->is_hidden)
                    <div>
                        <h2><b>Q: {{ $question->title['value'] }}</b></h2>
                        @if ($question->description)
                            <b>{{ $question->description['value'] }}</b>
                        @endif
                    </div>
                    <div>
                        @if ($question->answerquestion)
                            <p>Answer: <a href="{{ env('APP_URL') . '/storage/' . $question->answerquestion->value }}"
                                    download>{{ 'Answer' . $question->id }}</a>
                            </p>
                        @else
                            <p>Answer: -</p>
                        @endif
                    </div>
                @elseif($question->answer_type === 'key' && $question->options['key'] === 'team_members')
                    @if ($question->answerquestion && $question->answerquestion->value !== null && $question->answerquestion->value)
                        @foreach (json_decode($question->answerquestion->value, true) as $key => $member)
                            <div>
                                <h2>Team Member {{ $key + 1 }}</h2>
                            </div>
                            <div style="clear:both; position:relative;">
                                <div style="position:absolute; left:0pt; width:192pt;">
                                    <div>firstname: {{ $member['firstname'] }}</div>
                                    <div>address: {{ $member['address'] }}</div>
                                    <div>City: {{ $member['city'] }}</div>
                                    @if (isset($member['current_status_other']))
                                        <span>Other: {{ $member['current_status_other'] }}</span>
                                    @endif
                                    <div>zip: {{ $member['zip'] }}</div>
                                    <div>email: {{ $member['email'] }}</div>
                                </div>
                                <div style="margin-left:300pt;">
                                    <div>surname: {{ $member['surname'] }}</div>
                                    <div>phone: {{ $member['phone'] }}</div>
                                    @if (isset($member['title']))
                                        <span>title: {{ $member['title'] }}</span>
                                    @endif
                                    @if (isset($member['training']))
                                        <span>training: {{ $member['training'] }}</span>
                                    @endif
                                    <div>current status: {{ $member['current_status'] }}</div>
                                </div>
                            </div>
                        @endforeach
                        @else
                        <p>Answer: -</p>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</div>
