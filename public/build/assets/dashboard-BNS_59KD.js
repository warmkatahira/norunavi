import{s as w}from"./loading-CLXJ3Lsj.js";$(document).on("click",function(e){e.target.classList.contains("ride_schedule_select_modal_close")&&$("#ride_schedule_select_modal").addClass("hidden");const s=$(e.target).closest(".ride_schedule_select_modal_open");if(s.length){const a=s.data("route-type-id"),l=s.data("ride-id"),r=s.data("join-ride-detail-id");v(a,l,r),$("#ride_id").val(l),$("#ride_schedule_select_modal").removeClass("hidden")}});function v(e,s,a){$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:"/ajax/get_ride_schedule_select_info",type:"GET",data:{ride_id:s},dataType:"json",success:function(r){try{e===1?$("#ride_schedule_select_modal_title").html("乗車する場所を選択して下さい"):e===2&&$("#ride_schedule_select_modal_title").html("降車する場所を選択して下さい"),$("#ride_schedule_select_div").empty();let c=$('<div class="hidden md:block overflow-x-auto w-full"></div>'),i=$('<table class="text-sm w-full border-collapse"></table>'),h=$(`
                    <thead>
                        <tr class="text-left text-white bg-black whitespace-nowrap sticky top-0">
                            <th class="py-1 px-2 text-center">場所名</th>
                            <th class="py-1 px-2 text-center">場所メモ</th>
                            <th class="py-1 px-2 text-center">停車順番</th>
                            <th class="py-1 px-2 text-center">着 → 発</th>
                        </tr>
                    </thead>
                `),o=$('<tbody class="bg-white"></tbody>'),n=$('<div class="md:hidden space-y-2 w-full"></div>');r.ride_details.forEach(function(t){let u=y(t),d=!1;e===1?d=!!t.departure_time:e===2&&(d=!!t.arrival_time);let p="",_=t.ride_detail_id===a?"checked":"";d?p=`
                            <input type="radio"
                                name="ride_detail_id"
                                value="${t.ride_detail_id}"
                                ${_}
                                class="ride-detail-radio w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer">
                        `:p=`
                            <input type="radio" disabled
                                class="w-5 h-5 border-gray-200 opacity-30">
                        `;let f=d?"select-row hover:bg-theme-sub cursor-pointer":"bg-gray-100 text-gray-400 cursor-not-allowed",b=$(`
                        <tr data-id="${t.ride_detail_id}"
                            class="${f} border hover:bg-theme-sub cursor-pointer">
                            <td class="py-1 px-2">${t.location_name}</td>
                            <td class="py-1 px-2">${t.location_memo??""}</td>
                            <td class="py-1 px-2 text-right">${t.stop_order??""}</td>
                            <td class="py-1 px-2 text-center">${u}</td>
                        </tr>
                    `);o.append(b);let x=d?"w-full select-row ride-card border rounded-xl p-3 shadow-sm cursor-pointer":"w-full ride-card border rounded-xl p-3 shadow-sm bg-gray-100 text-gray-400 cursor-not-allowed",g=$(`
                        <div data-id="${t.ride_detail_id}"
                            class="${x}">
                            <div class="font-semibold">
                                ${t.location_name}
                                <span class="text-sm text-gray-600">${t.location_memo??""}</span>
                            </div>
                            <div class="text-sm text-center mt-2 font-medium">
                                ${u}
                            </div>
                        </div>
                    `);n.append(g)}),i.append(h),i.append(o),c.append(i),$("#ride_schedule_select_div").append(c).append(n),a&&($("#selected_ride_detail_id").val(a),$(".select-row").removeClass("bg-theme-sub").addClass("bg-white"),$(`.select-row[data-id="${a}"]`).removeClass("bg-white").addClass("bg-theme-sub"))}catch{}},error:function(){alert("失敗")}})}function y(e){let s=e.departure_time?m(e.departure_time):null,a=e.arrival_time?m(e.arrival_time):null,l="";return a&&s?l=`<span class="text-orange-700 font-medium">${a} 着</span>
                    <span class="mx-1">→</span>
                    <span class="text-blue-700 font-medium">${s} 発</span>`:a?l=`<span class="text-orange-700 font-medium">${a} 着</span>`:s?l=`<span class="text-blue-700 font-medium">${s} 発</span>`:l='<span class="text-gray-400">—</span>',l}function m(e){return e?e.split(":").slice(0,2).join(":"):null}$(document).on("click",".select-row",function(){if($(this).hasClass("cursor-not-allowed"))return;let e=$(this).data("id");$("#selected_ride_detail_id").val(e),$(".select-row").removeClass("bg-theme-sub").addClass("bg-white"),$(`.select-row[data-id="${e}"]`).removeClass("bg-white").addClass("bg-theme-sub")});$("#ride_schedule_select_enter").on("click",function(){window.confirm("選択を確定しますか？")===!0&&(w(),$("#ride_schedule_select_form").submit())});
