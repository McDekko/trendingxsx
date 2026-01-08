<div class="card p-3 mb-3">
    <form action="/post" method="POST" enctype="multipart/form-data">
        @csrf
        <textarea
            class="form-control bg-dark text-white mb-2"
            name="content"
            rows="3"
            placeholder="Apa yang sedang terjadi?"
            required
        ></textarea>

        <div class="d-flex justify-content-between align-items-center">
            <input
                type="file"
                name="media"
                class="form-control form-control-sm bg-dark text-white w-50"
            >
            <button class="btn btn-primary">Post</button>
        </div>
    </form>
</div>