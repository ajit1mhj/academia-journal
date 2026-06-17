@extends('layouts.public')
@section('title', 'Publication Ethics')

@section('content')
<div class="py-4 bg-light border-bottom">
    <div class="container">
        <h1 class="h3 fw-bold text-primary mb-0">Publication Ethics</h1>
    </div>
</div>

<section class="py-5">
    <div class="container" style="max-width:860px">

        @foreach([
            ['bi-person-check','Duties of Authors','Authors must ensure their work is original and has not been published elsewhere. Plagiarism, data fabrication, and falsification are strictly prohibited. All authors listed must have made a significant contribution to the work. Conflicts of interest must be disclosed.'],
            ['bi-clipboard2-check','Duties of Reviewers','Reviewers must treat manuscripts as confidential documents. Reviews should be objective and constructive. Reviewers must disclose conflicts of interest and decline to review if they exist. Personal criticism of the author is inappropriate.'],
            ['bi-pencil-square','Duties of Editors','Editors must evaluate manuscripts based solely on their academic merit without regard to race, gender, religion, ethnicity, nationality, or political views. Editors must maintain confidentiality and not use unpublished information for their own research.'],
            ['bi-ban','Plagiarism Policy','AJMS uses plagiarism detection software on all submissions. Manuscripts with a similarity index above 20% will be returned to authors. Confirmed cases of plagiarism will result in immediate rejection and may be reported to the author\'s institution.'],
            ['bi-arrow-repeat','Retraction Policy','Articles may be retracted if misconduct is confirmed, results are found to be unreliable, or duplicate publication is discovered. Retractions are published with a clear notice explaining the reason.'],
        ] as $section)
        <div class="d-flex gap-3 mb-4 p-4 bg-white rounded shadow-sm">
            <i class="bi {{ $section[0] }} text-primary fs-3 mt-1"></i>
            <div>
                <h5 class="fw-bold mb-2" style="color:#1a3c5e">{{ $section[1] }}</h5>
                <p class="text-muted mb-0 small">{{ $section[2] }}</p>
            </div>
        </div>
        @endforeach

    </div>
</section>
@endsection