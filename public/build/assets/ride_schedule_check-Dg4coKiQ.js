$(document).on("click",function(e){e.target.classList.contains("ride_schedule_check_modal_close")&&$("#ride_schedule_check_modal").addClass("hidden");const t=$(e.target).closest(".ride_schedule_check_modal_open");if(t.length){const l=t.data("route-type-id"),s=t.data("ride-id");t.data("join-ride-detail-id"),v(l,s),$("#ride_id").val(s)}});function v(e,t,l){$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:"/ajax/get_ride_schedule_select_info",type:"GET",data:{ride_id:t},dataType:"json",success:function(i){try{$("#ride_schedule_check_div").empty();let n=$('<div class="hidden md:block overflow-x-auto w-full"></div>'),p=`<div class="mb-3 text-xl">${i.schedule_date}</div>`,_=$(p),f=$(p),c=$('<table class="text-sm w-full border-collapse"></table>'),x=$(`
                    <thead>
                        <tr class="text-left text-white bg-black whitespace-nowrap sticky top-0">
                            <th class="py-1 px-2 font-thin text-center">場所名</th>
                            <th class="py-1 px-2 font-thin text-center">場所メモ</th>
                            <th class="py-1 px-2 font-thin text-center">停車順番</th>
                            <th class="py-1 px-2 font-thin text-center">着 → 発</th>
                            <th class="py-1 px-2 font-thin text-center">利用者</th>
                        </tr>
                    </thead>
                `),o=$('<tbody class="bg-white"></tbody>'),d=$('<div class="md:hidden space-y-2 w-full"></div>');d.append(f),i.ride_details.forEach(function(a){let u=g(a),r="";a.ride_users&&a.ride_users.length>0&&a.ride_users.forEach(function(h){r+=`
                                <span class="inline-flex items-center gap-1 bg-gray-200 border border-gray-300 rounded-full px-2 py-0.5 text-xs whitespace-nowrap writing-horizontal"
                                    style="flex: 0 0 calc(12% - 0.5rem);">
                                    <span class="tippy_ride_user cursor-default text-center w-full"
                                        data-full-name="${h.user.last_name}">
                                        ${h.user.last_name}
                                    </span>
                                </span>
                            `});let y=$(`
                        <tr
                            class="border hover:bg-theme-sub whitespace-nowrap">
                            <td class="py-1 px-2">${a.location_name}</td>
                            <td class="py-1 px-2">${a.location_memo??""}</td>
                            <td class="py-1 px-2 text-right">${a.stop_order??""}</td>
                            <td class="py-1 px-2 text-center">${u}</td>
                            <td class="py-1 px-2 text-center">
                                <div class="flex flex-row flex-wrap gap-2 justify-start">
                                    ${r}
                                </div>
                            </td>
                        </tr>
                    `);o.append(y);let b=$(`
                        <div
                            class="bg-white w-full ride-card border rounded-xl p-3 shadow-sm">
                            <div class="font-semibold">
                                ${a.location_name}
                                <span class="text-sm text-gray-600">${a.location_memo??""}</span>
                            </div>
                            <div class="text-sm text-center mt-2 font-medium">
                                ${u}
                            </div>
                            <div class="text-sm text-left mt-2 font-medium space-y-2">
                                ${r}
                            </div>
                        </div>
                    `);d.append(b)}),c.append(x),c.append(o),n.append(_),n.append(c),$("#ride_schedule_check_div").append(n).append(d),$("#ride_schedule_check_modal").removeClass("hidden")}catch{}},error:function(){alert("失敗")}})}function g(e){let t=e.departure_time?m(e.departure_time):null,l=e.arrival_time?m(e.arrival_time):null,s="";return l&&t?s=`<span class="text-orange-700 font-medium">${l} 着</span>
                    <span class="mx-1">→</span>
                    <span class="text-blue-700 font-medium">${t} 発</span>`:l?s=`<span class="text-orange-700 font-medium">${l} 着</span>`:t?s=`<span class="text-blue-700 font-medium">${t} 発</span>`:s='<span class="text-gray-400">—</span>',s}function m(e){return e?e.split(":").slice(0,2).join(":"):null}
