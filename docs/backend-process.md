# Shastra Backend Process

## Goal

Build the backend in a simple and safe way.

The backend should:
- support the marketing website
- support the CMS dashboard
- stay easy to read
- stay easy to extend later

## Main Idea

We do not build everything at once.

We build in steps:
1. keep the frontend working
2. add backend foundation
3. connect CMS content
4. improve the CMS over time

## Build Order

### 1. Define the content shape first

Before building database tables, decide:
- what is global site content
- what is page content
- what is repeater content
- what is real app data

Examples:
- global content: brand, navigation, footer, contact info
- page content: home hero, about story, services content
- repeater content: stats, cards, social links
- real app data: contact form submissions

### 2. Keep one content service for the frontend

The frontend should read content from one service layer.

Do not let Blade files or controllers read random places directly.

This gives us:
- one clean source of truth
- less rework
- easier future changes

### 3. Start with simple schema

Use simple tables first:
- `site_settings` for shared site content
- `content_pages` for fixed page content
- `contact_submissions` for contact form data

This is good for now because the site structure is still being finalized.

### 4. Keep controllers thin

Controllers should only:
- receive the request
- call a service
- return a response

Do not put heavy logic in controllers.

### 5. Put logic in services

Use service classes for:
- loading content
- saving CMS content
- storing contact submissions
- future sync tools

This keeps code cleaner and easier for the team to follow.

### 6. Validate all input

Use Form Requests for:
- contact form
- CMS login
- CMS content updates

Validation should happen before saving data.

### 7. Build CMS in priority order

Build the CMS in this order:
1. admin access
2. global settings
3. home and contact content
4. about and services content
5. projects and templates later

Do not build low-priority CMS sections too early.

### 8. Add setup tools

Create small helper tools for the team:
- `cms:create-admin`
- `cms:sync-config`

These tools make setup cleaner and safer.

### 9. Test each backend feature

Add tests for:
- content loading
- database override behavior
- contact form saving
- CMS auth and admin access

### 10. Only make complex schema when needed

Keep JSON content for fixed sections for now.

Make separate tables later only if the content needs:
- filtering
- sorting
- relations
- publishing flow
- its own lifecycle

Examples that may become real tables later:
- projects
- templates

## Code Rules

- Keep public site and CMS clearly separated
- Use simple names
- Keep files focused
- One class = one main job
- No business logic in Blade
- No heavy logic in routes
- Prefer clear code over clever code

## Simple Structure

- `Controllers`: request in, response out
- `Requests`: validation
- `Services`: business logic
- `Models`: data
- `Views`: display only
- `Routes`: public routes and CMS routes stay separate

## Current Direction

Right now the backend should stay fixed-section based.

That means:
- layout stays in code
- styles stay in code
- animation stays in code
- editable content goes to CMS

This project should not become a drag-and-drop page builder.

## Next Backend Steps

1. add admin creation command
2. add config-to-database sync command
3. replace important JSON editors with typed CMS fields
4. improve contact submission workflow
5. build projects and templates only when their final structure is clear
