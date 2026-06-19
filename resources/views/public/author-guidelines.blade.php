@extends('layouts.public')

@section('title', 'Submissions')

@section('content')
<div class="container py-5">

    <h1 class="section-title mb-4">Submissions</h1>

    {{-- Submission Checklist --}}
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Submission Preparation Checklist</h4>
        </div>

        <div class="card-body">
            <p>
                As part of the submission process, authors are required to confirm that their manuscript
                complies with all of the following requirements.
                Submissions that do not adhere to these guidelines may be returned for revision before
                being considered for review.
            </p>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    The manuscript is original and has not been published previously,
                    nor is it under consideration by another journal.
                </li>

                <li class="list-group-item">
                    The manuscript is submitted in Microsoft Word (.doc or .docx) format.
                </li>

                <li class="list-group-item">
                    All references cited in the text are included in the reference list,
                    and DOI or URL links are provided where available.
                </li>

                <li class="list-group-item">
                    The manuscript follows the formatting and referencing style
                    prescribed in these Author Guidelines.
                </li>

                <li class="list-group-item">
                    The manuscript has been prepared for blind peer review by removing
                    author names, affiliations, acknowledgements, and any identifying information.
                </li>

                <li class="list-group-item">
                    Tables, figures, and illustrations are embedded within the text at
                    appropriate locations and are clearly labelled.
                </li>

                <li class="list-group-item">
                    Authors have obtained permission for the use of copyrighted materials where necessary.
                </li>

                <li class="list-group-item">
                    The manuscript complies with ethical standards regarding plagiarism,
                    authorship, and research integrity.
                </li>
            </ul>
        </div>
    </div>


    {{-- Author Guidelines --}}
    <h2 class="section-title mb-4">Author Guidelines</h2>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <h4>About the Journal</h4>

            <p>
                <strong>Academia International College Journal (AICJ)</strong> is a peer-reviewed,
                open-access academic journal published by Academia International College.
                The journal provides a platform for researchers, scholars, educators,
                and professionals to disseminate original research and scholarly works
                across diverse disciplines.
            </p>

            <p>The journal welcomes:</p>

            <ul>
                <li>Original research articles</li>
                <li>Review articles</li>
                <li>Short communications</li>
                <li>Case studies</li>
                <li>Reflective and opinion papers</li>
                <li>Book reviews</li>
                <li>Conference reports</li>
            </ul>

            <p>
                Submissions should contribute significantly to theory, practice,
                or policy and demonstrate scholarly rigor and originality.
            </p>

            <hr>

            <h4>Peer Review Process</h4>

            <p>
                All submitted manuscripts undergo a
                <strong>double-blind peer review</strong> process consisting of:
            </p>

            <ol>
                <li>
                    Initial editorial screening for scope, quality,
                    and compliance with submission guidelines.
                </li>

                <li>
                    Review by at least two anonymous experts
                    in the relevant field.
                </li>

                <li>
                    Editorial decision based on reviewers' recommendations.
                </li>
            </ol>

            <p><strong>Possible editorial decisions:</strong></p>

            <ul>
                <li>Accept</li>
                <li>Accept with Minor Revisions</li>
                <li>Revise and Resubmit</li>
                <li>Reject</li>
            </ul>

            <p>
                The review process generally takes
                <strong>6–12 weeks</strong>, although this may vary depending
                on reviewer availability.
            </p>

            <hr>

            <h4>Legal and Ethical Requirements</h4>

            <ul>
                <li>The manuscript is the author's original work.</li>
                <li>The manuscript has not been published previously.</li>
                <li>All authors have approved the submission.</li>
                <li>Appropriate ethical approval has been obtained.</li>
                <li>Any conflict of interest has been disclosed.</li>
                <li>The manuscript contains no plagiarized material.</li>
            </ul>

            <hr>

            <h4>Manuscript Preparation</h4>

            <ul>
                <li><strong>Language:</strong> English</li>
                <li>
                    <strong>Word Count:</strong>

                    <ul>
                        <li>Research Articles: 5,000–8,000 words</li>
                        <li>Review Articles: 4,000–8,000 words</li>
                        <li>Short Communications: 1,500–3,000 words</li>
                    </ul>
                </li>

                <li><strong>Abstract:</strong> 150–250 words</li>

                <li><strong>Keywords:</strong> 3–5 keywords</li>

                <li>
                    <strong>File Format:</strong>
                    Microsoft Word (.doc or .docx)
                </li>
            </ul>

            <hr>

            <h4>Page Layout and Formatting</h4>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th>
                            <th>Requirement</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Font</td>
                            <td>Times New Roman</td>
                        </tr>

                        <tr>
                            <td>Font Size</td>
                            <td>12 pt</td>
                        </tr>

                        <tr>
                            <td>Line Spacing</td>
                            <td>Double</td>
                        </tr>

                        <tr>
                            <td>Page Margin</td>
                            <td>1 inch on all sides</td>
                        </tr>

                        <tr>
                            <td>Alignment</td>
                            <td>Left aligned</td>
                        </tr>

                        <tr>
                            <td>Paragraph Indent</td>
                            <td>0.5 inch</td>
                        </tr>

                        <tr>
                            <td>Paper Size</td>
                            <td>A4</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <h4>In-Text Citations</h4>

            <p>
                The journal follows
                <strong>APA 7th Edition</strong> referencing style.
            </p>

            <ul>
                <li>One Author: (Smith, 2023)</li>
                <li>Two Authors: (Brown &amp; Lee, 2022)</li>
                <li>Three or More Authors: (Jones et al., 2021)</li>
                <li>Direct Quote: "Education is a transformative process"
                    (Sharma, 2020, p. 25)
                </li>
            </ul>

            <hr>

            <h4>Conflict of Interest</h4>

            <p>
                Authors must disclose any financial, professional,
                or personal relationships that could influence their research.
            </p>

            <p>
                <strong>Conflict of Interest:</strong>
                The authors declare no conflict of interest.
            </p>

            <hr>

            <h4>Anti-Plagiarism Policy</h4>

            <ul>
                <li>All submissions are screened using plagiarism detection software.</li>
                <li>Manuscripts with substantial similarity may be rejected.</li>
                <li>
                    Fabrication, falsification, duplicate submission,
                    and unethical authorship practices are strictly prohibited.
                </li>
            </ul>

            <hr>

            <h4>Copyright and Licensing</h4>

            <p>
                Authors retain copyright of their published work.
            </p>

            <p>
                Accepted articles are published under the
                <strong>Creative Commons Attribution-ShareAlike (CC BY-SA 4.0)</strong>
                License.
            </p>

            <hr>

            <h4>Contact Information</h4>

            <p>
                <strong>Academia International College Journal</strong><br>
                Academia International College<br>
                Gwarko, Lalitpur, Nepal
            </p>

            <p>
                Email:
                <a href="mailto:research@academiacollege.edu.np">
                    research@academiacollege.edu.np
                </a>
            </p>

            <p>
                Website:
                <a href="https://academiacollege.edu.np" target="_blank">
                    https://academiacollege.edu.np
                </a>
            </p>

        </div>
    </div>

</div>
@endsection