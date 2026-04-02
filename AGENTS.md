# AGENTS.md

## Project Direction

- This codebase is for a marketing website and a CMS dashboard in the same Laravel project
- Keep the public-facing frontend and the CMS/dashboard code clearly separated in structure and responsibility
- Build the frontend so it stays easy to maintain, easy to extend, and easy for another developer to continue without reworking the code

## Frontend Stack

- Prefer Tailwind CSS as much as possible for layout, spacing, typography, colors, responsiveness, and states
- Use custom CSS only when Tailwind utilities are not enough or when a repeated pattern clearly belongs in a shared class
- Use AOS for scroll and entrance animations on the marketing frontend
- Do not introduce extra animation libraries unless there is a strong reason and the team explicitly agrees

## Tailwind Rules

- Keep styling utility-first and consistent with Tailwind best practices
- Prefer clean utility composition over large custom CSS blocks
- When styles repeat, extract them into reusable Blade components or shared utility classes in `resources/css/app.css`
- Avoid inline styles unless the value must be dynamic and cannot be handled cleanly another way
- Keep class lists readable and grouped logically: layout, spacing, typography, color, state

## Blade And Markup Rules

- Add a short comment above each major section block so the page structure is easy to scan
- Keep section names clear and practical, for example: `Hero Section`, `Services Section`, `Footer Section`
- Write Blade templates in a way that another developer can quickly understand and continue
- Avoid unnecessary duplication in markup; extract repeated UI into Blade components or partials
- Keep the HTML semantic and accessibility-friendly

## CMS Readiness

- Build the marketing frontend with CMS updates in mind
- Assume text, images, videos, buttons, and repeated sections may later come from the dashboard
- Avoid hard-coding structure in a way that makes future CMS integration harder
- Keep content areas easy to swap from static placeholders to database-driven data

## Code Quality

- Keep the codebase clean, organized, and readable
- Prefer simple, maintainable solutions over clever or overly complex ones
- Name files, variables, and components clearly
- Do not leave dead code, temporary experiments, or unclear structure behind
- Make decisions that support team handoff and long-term maintenance

## Frontend Goal

- The frontend should stay aligned with the marketing goal of the website
- It should feel polished, responsive, and production-ready
- It should follow the approved visual direction from the design while remaining practical for development and CMS editing
