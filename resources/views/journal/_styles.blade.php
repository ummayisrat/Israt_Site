<style>
    .journal-page { max-width: 1100px; margin: auto; padding: 70px 25px 100px; }
    .journal-toolbar { display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap; margin-bottom: 50px; }
    .journal-toolbar h1 { font-size: clamp(40px, 6vw, 70px); font-weight: normal; letter-spacing: -3px; line-height: 1; }
    .journal-toolbar h1 span { color: #b47752; font-style: italic; }

    .flash { background: rgba(180,119,82,.12); border: 1px solid rgba(180,119,82,.4); color: #8a5636; padding: 14px 20px; border-radius: 12px; margin-bottom: 35px; }

    .journal-entry { display: grid; grid-template-columns: 1fr 1fr; gap: 45px; align-items: center; margin-bottom: 60px; background: rgba(255,250,242,.72); border: 1px solid rgba(210,198,180,.65); border-radius: 18px; padding: 20px; overflow: hidden; transition: transform .4s ease, box-shadow .4s ease; }
    .journal-entry:hover { transform: translateY(-8px); box-shadow: 0 25px 70px rgba(0,0,0,.10), 0 0 35px rgba(180,119,82,.08); }
    .journal-entry.no-image { grid-template-columns: 1fr; }
    .journal-image { height: 380px; overflow: hidden; border-radius: 12px; }
    .journal-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .journal-content { padding: 20px 30px; }
    .journal-date { color: #b47752; font-size: 12px; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 18px; }
    .journal-content h2 { font-size: 36px; font-weight: normal; line-height: 1.1; margin-bottom: 20px; }
    .journal-content p { color: #707070; font-size: 17px; line-height: 1.9; margin-bottom: 25px; white-space: pre-line; }

    .actions { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
    .actions form { display: inline; }
    .button.secondary { background: transparent; color: #292621; border: 1px solid #292621; }
    .button.secondary:hover { background: #292621; color: #fff; }
    .button.danger { background: #a43d3d; }
    .button.danger:hover { background: #7c2828; }

    .journal-form { max-width: 720px; margin: auto; background: rgba(255,250,242,.8); border: 1px solid rgba(210,198,180,.65); border-radius: 18px; padding: 40px; }
    .journal-form label { display: block; margin: 20px 0 6px; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; color: #b47752; }
    .journal-form input, .journal-form textarea { width: 100%; padding: 13px 16px; border: 1px solid rgba(210,198,180,.9); border-radius: 10px; font: inherit; background: #fff; color: #292621; }
    .journal-form textarea { min-height: 200px; resize: vertical; }
    .journal-form input:focus, .journal-form textarea:focus { outline: none; border-color: #b47752; box-shadow: 0 0 0 3px rgba(180,119,82,.15); }
    .field-error { color: #a43d3d; font-size: 14px; margin-top: 6px; }
    .journal-form .actions { margin-top: 30px; }

    .empty-state { text-align: center; padding: 80px 20px; color: #777; }
    .pagination-wrap { display: flex; gap: 8px; justify-content: center; margin-top: 20px; }
    .pagination-wrap a, .pagination-wrap span.current { padding: 8px 14px; border-radius: 20px; border: 1px solid rgba(210,198,180,.9); text-decoration: none; color: inherit; }
    .pagination-wrap span.current { background: #292621; color: #fff; }

    @media (max-width: 750px) {
        .journal-entry { grid-template-columns: 1fr; gap: 20px; padding: 12px; }
        .journal-image { height: 260px; }
        .journal-content { padding: 20px; }
        .journal-content h2 { font-size: 28px; }
        .journal-form { padding: 25px; }
    }
</style>
