# Shastra CMS Content Schema Notes

## Current Direction

- This project should use a fixed-schema CMS, not a drag-and-drop page builder
- The Laravel app should contain both the marketing website and the CMS dashboard
- The public frontend and the CMS/dashboard should stay clearly separated in structure

## Workflow Recommendation

- Finish the About page UI first
- While building pages, keep content structured as if it already comes from the database
- After About is stable, start the backend CMS foundation
- Build the admin dashboard after the main page structures are clear

## Why This Approach Fits The Design

- The design is page-based and section-based
- The content patterns are repeated and predictable
- Most editable parts are text, media, links, cards, stats, and repeaters
- The layout system itself should stay in code, not in the CMS

## Global CMS Content

- Brand name
- Logo
- Navigation items
- Contact details
- Social links
- Footer CTA
- Footer team section
- Footer legal links
- Default SEO settings

## Home Page CMS Content

- Hero eyebrow
- Hero title
- Hero accent text
- Hero description
- Hero primary CTA
- Hero secondary CTA
- Hero video or image
- KPI items
- Services preview cards
- Why choose us content
- Portfolio teaser content

## Services Page CMS Content

- Page hero
- Service cards repeater
- Difference section
- Supporting media or video section
- Portfolio teaser or related content

## About Page CMS Content

- Page hero
- Company story
- Company profile download file
- Philosophy section
- Mission
- Vision
- Core values repeater

## Projects Page CMS Content

- Page hero
- Category or filter labels
- Project cards repeater
- Featured concept or project detail block

## Templates Page CMS Content

- Page hero
- Template list or grid repeater
- CTA or detail links

## Contact Page CMS Content

- Page hero
- Contact intro text
- Contact details
- Opening hours
- Supporting media
- CTA blocks

## Contact Form Note

- The contact page content is CMS-managed
- The contact form submission flow is backend logic
- Do not mix CMS editable text with form submission storage

## Things That Should Stay In Code

- Layout structure
- Responsive behavior
- Typography system
- Spacing system
- Animations
- Tailwind and custom CSS structure
- Blade component logic

## Suggested Future Backend Pieces

- Site settings model
- Navigation item model
- Social link model
- Page model
- Page hero data
- Service item model
- Project model
- Footer settings model
- Contact settings model
- Contact submission model

## Practical Next Step

- Freeze the shared content patterns
- Then create the database schema and CMS dashboard
