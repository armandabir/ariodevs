export default function Pagination({current_page,last_page,cat}){
    const pages = [];
    for (let i = 1; i <= last_page; i++) {
        pages.push(<button key={i}>{i}</button>);
    }
    return(
        <div className="flex justify-center items-center gap-2 mt-10">
            {current_page>1 && <button onClick={()=>window.location.href=`/cats/${cat}/?page=${current_page-1}`} className="bg-gray-200 px-4 py-2 rounded-md">قبلی</button>}
            <div className="flex gap-2">
                {pages}
            </div>         
            {current_page<last_page && <button onClick={()=>window.location.href=`/cats/${cat}/?page=${current_page+1}`} className="text-white px-4 py-2 rounded-md h-full bg-slate-700 ">بعدی</button>}

        </div>
    )

}