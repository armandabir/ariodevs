export default function Pagination({current_page,setCurrent_page,last_page, maincat,cat,contentFetcher}) {
    const pages = [];

    const changePage = (page) => {
        setCurrent_page(page);
        contentFetcher(maincat, cat,page);
        const target = document.getElementById("tag");
        if (target) {
            target.scrollIntoView({ behavior: "smooth", block: "start" });
        }
    };

    for (let i = 1; i <= last_page; i++) {
        pages.push(
            <button
                key={i}
                className={`px-3 py-2 rounded-md border ${i === current_page ? 'border-orange-500' : 'border-white'}`}
                onClick={() => changePage(i)}
            >
                {i}
            </button>
        );
    }
    return(
        <div className="flex justify-center items-center gap-2 mt-10">
            {current_page > 1 && <button onClick={() => changePage(current_page - 1)} className="text-white px-4 py-2 rounded-md h-full bg-slate-700">قبلی</button>}
            <div className="flex gap-2">
                {pages}
            </div>         
            {current_page < last_page && <button onClick={() => changePage(current_page + 1)} className="text-white px-4 py-2 rounded-md h-full bg-slate-700 ">بعدی</button>}

        </div>
    )

}