$(document).on("click",function(t){t.target.classList.contains("ride_schedule_check_modal_close")&&$("#ride_schedule_check_modal").addClass("hidden");const s=$(t.target).closest(".ride_schedule_check_modal_open");if(s.length){const a=s.data("route-type-id"),l=s.data("ride-id");s.data("join-ride-detail-id"),C(a,l),$("#ride_id").val(l)}});function C(t,s,a){$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:"/ajax/get_ride_schedule_select_info",type:"GET",data:{ride_id:s},dataType:"json",success:function(n){var m,u;try{$("#ride_schedule_check_div").empty();let c=$('<div class="hidden md:block overflow-x-auto w-full"></div>'),_=`<div class="mb-2 text-xl"><i class="las la-calendar la-lg mr-1"></i>${n.schedule_date}</div>`,h=`<div class="mb-2 ml-5 text-sm"><i class="las la-comment la-lg mr-1"></i>${n.ride.ride_memo??"なし"}</div>`,p="";(u=(m=n.ride)==null?void 0:m.confirmed_driver_candidates)!=null&&u.length?p=n.ride.confirmed_driver_candidates.map(e=>{let d=e.vehicle,r=d?`${d.vehicle_name} (${d.vehicle_number})`:"未登録";return`
                                <div class="mb-2 ml-5 text-sm">
                                    <i class="las la-user la-lg"></i>
                                    ${e.user.full_name}
                                    <i class="las la-car-side la-lg ml-3"></i>
                                    ${r}
                                </div>
                            `}).join(""):p=`
                        <div class="mb-2 ml-5 text-sm">
                            <i class="las la-car-side la-lg mr-1"></i>
                            未登録
                        </div>
                    `;let y=$(_),b=$(_),g=$(h),w=$(h),k=$(p),j=$(p),o=$('<table class="text-sm w-full border-collapse"></table>'),H=$(`
                    <thead>
                        <tr class="text-left text-white bg-black whitespace-nowrap sticky top-0">
                            <th class="py-1 px-2 font-thin text-center">場所名</th>
                            <th class="py-1 px-2 font-thin text-center">場所メモ</th>
                            <th class="py-1 px-2 font-thin text-center">停車順番</th>
                            <th class="py-1 px-2 font-thin text-center">着 → 発</th>
                            <th class="py-1 px-2 font-thin text-center">利用者</th>
                        </tr>
                    </thead>
                `),f=$('<tbody class="bg-white"></tbody>'),i=$('<div class="md:hidden space-y-2 w-full"></div>');i.append(b),i.append(w),i.append(j),n.ride_details.forEach(function(e){let d=z(e),r="";e.ride_users&&e.ride_users.length>0&&e.ride_users.forEach(function(x){r+=`
                                <span class="inline-flex items-center gap-1 bg-gray-200 border border-gray-300 rounded-full px-2 py-0.5 text-xs whitespace-nowrap writing-horizontal"
                                    style="flex: 0 0 calc(12% - 0.5rem);">
                                    <span class="tippy_ride_user cursor-default text-center w-full"
                                        data-full-name="${x.user.last_name}">
                                        ${x.user.last_name}
                                    </span>
                                </span>
                            `});let T=$(`
                        <tr
                            class="border hover:bg-theme-sub whitespace-nowrap">
                            <td class="py-1 px-2">${e.location_name}</td>
                            <td class="py-1 px-2">${e.location_memo??""}</td>
                            <td class="py-1 px-2 text-right">${e.stop_order??""}</td>
                            <td class="py-1 px-2 text-center">${d}</td>
                            <td class="py-1 px-2 text-center">
                                <div class="flex flex-row flex-wrap gap-2 justify-start">
                                    ${r}
                                </div>
                            </td>
                        </tr>
                    `);f.append(T);let E=$(`
                        <div
                            class="bg-white w-full ride-card border rounded-xl p-3 shadow-sm">
                            <div class="font-semibold">
                                ${e.location_name}
                                <span class="text-sm text-gray-600">${e.location_memo??""}</span>
                            </div>
                            <div class="text-sm text-center mt-2 font-medium">
                                ${d}
                            </div>
                            <div class="text-sm text-left mt-2 font-medium space-y-2">
                                ${r}
                            </div>
                        </div>
                    `);i.append(E)}),o.append(H),o.append(f),c.append(y),c.append(g),c.append(k),c.append(o),$("#ride_schedule_check_div").append(c).append(i),$("#ride_schedule_check_modal").removeClass("hidden")}catch{}},error:function(){alert("失敗")}})}function z(t){let s=t.departure_time?v(t.departure_time):null,a=t.arrival_time?v(t.arrival_time):null,l="";return a&&s?l=`<span class="text-orange-700 font-medium">${a} 着</span>
                    <span class="mx-1">→</span>
                    <span class="text-blue-700 font-medium">${s} 発</span>`:a?l=`<span class="text-orange-700 font-medium">${a} 着</span>`:s?l=`<span class="text-blue-700 font-medium">${s} 発</span>`:l='<span class="text-gray-400">—</span>',l}function v(t){return t?t.split(":").slice(0,2).join(":"):null}
