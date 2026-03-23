@extends('layouts.cms')

@section('title', 'Contact Submissions | Shastra CMS')

@section('content')
    {{-- Contact submissions header --}}
    <section class="rounded-[2rem] bg-white p-6 shadow-sm">
        <p class="text-sm uppercase tracking-[0.3em] text-amber-500">Contact Inbox</p>
        <h1 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">Live contact submissions</h1>
        <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">
            These entries come from the public contact form and are stored separately from CMS-managed content.
        </p>
    </section>

    {{-- Contact submissions table --}}
    <section class="overflow-hidden rounded-[2rem] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Name</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Email</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Project Type</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Message</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Submitted</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($submissions as $submission)
                        <tr class="align-top">
                            <td class="px-6 py-4 text-sm text-slate-900">
                                {{ $submission->first_name }} {{ $submission->last_name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                <a href="mailto:{{ $submission->email_address }}" class="underline underline-offset-4">
                                    {{ $submission->email_address }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $submission->project_type }}</td>
                            <td class="px-6 py-4 text-sm leading-6 text-slate-700">{{ $submission->message }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $submission->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">
                                No contact submissions yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-6 py-4">
            {{ $submissions->links() }}
        </div>
    </section>
@endsection
