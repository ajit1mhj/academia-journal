@extends('layouts.public')

@section('title', 'Submissions')

@section('content')

<div class="container py-5">

    <h1 class="section-title mb-4">Submissions</h1>

    <h3 class="mb-4">Submission Checklist</h3>

    <p>
        Before submitting a manuscript, authors must ensure that their submission
        satisfies all of the following requirements. Manuscripts that fail to meet
        these criteria may be returned for correction prior to the review process.
    </p>

    <ol class="mt-3">
        <li class="mb-3">
            The manuscript is an original work, has not been published previously,
            and is not currently under review by another journal. If otherwise,
            an explanation has been provided to the Editor.
        </li>

        <li class="mb-3">
            The manuscript file has been prepared in an accepted format,
            including OpenOffice, Microsoft Word (.doc or .docx),
            RTF, or WordPerfect.
        </li>

        <li class="mb-3">
            Digital Object Identifiers (DOIs) have been included for references
            wherever they are available.
        </li>

        <li class="mb-3">
            All figures, tables, charts, and illustrations are inserted within
            the main text at their appropriate positions rather than being placed
            at the end of the manuscript.
        </li>

        <li class="mb-3">
            The manuscript conforms to the formatting, citation, and bibliographic
            style requirements specified in the Author Guidelines.
        </li>

        <li class="mb-3">
            For manuscripts submitted to peer-reviewed sections, all identifying
            information has been removed and the guidelines for blind peer review
            have been properly followed.
        </li>
    </ol>

</div>

@endsection
```