$(document).on("click",function(e){e.target.classList.contains("ride_schedule_check_modal_close")&&$("#ride_schedule_check_modal").addClass("hidden");const t=$(e.target).closest(".ride_schedule_check_modal_open");if(t.length){const a=t.data("route-type-id"),s=t.data("ride-id");t.data("join-ride-detail-id"),T(a,s),$("#ride_id").val(s)}});function T(e,t,a){$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:"/ajax/get_ride_schedule_select_info",type:"GET",data:{ride_id:t},dataType:"json",success:function(c){var p,o;try{$("#ride_schedule_check_div").empty();let n=$('<div class="hidden md:block overflow-x-auto w-full"></div>'),m=`<div class="mb-3 text-xl"><i class="las la-calendar la-lg mr-1"></i>${c.schedule_date}</div>`,u=`<div class="mb-3 text-base"><i class="las la-comment la-lg mr-1"></i>${c.ride.ride_memo??"なし"}</div>`,h=`<div class="mb-3 text-base"><i class="las la-car-side la-lg mr-1"></i>${(o=(p=c.ride)==null?void 0:p.vehicle)!=null&&o.vehicle_name?c.ride.vehicle.vehicle_name+"("+c.ride.vehicle.vehicle_number+")":"未登録"}</div>`,y=$(m),b=$(m),g=$(u),w=$(u),k=$(h),z=$(h),i=$('<table class="text-sm w-full border-collapse"></table>'),j=$(`
                    <thead>
                        <tr class="text-left text-white bg-black whitespace-nowrap sticky top-0">
                            <th class="py-1 px-2 font-thin text-center">場所名</th>
                            <th class="py-1 px-2 font-thin text-center">場所メモ</th>
                            <th class="py-1 px-2 font-thin text-center">停車順番</th>
                            <th class="py-1 px-2 font-thin text-center">着 → 発</th>
                            <th class="py-1 px-2 font-thin text-center">利用者</th>
                        </tr>
                    </thead>
                `),_=$('<tbody class="bg-white"></tbody>'),d=$('<div class="md:hidden space-y-2 w-full"></div>');d.append(b),d.append(w),c.ride_details.forEach(function(l){let x=C(l),r="";l.ride_users&&l.ride_users.length>0&&l.ride_users.forEach(function(f){r+=`
                                <span class="inline-flex items-center gap-1 bg-gray-200 border border-gray-300 rounded-full px-2 py-0.5 text-xs whitespace-nowrap writing-horizontal"
                                    style="flex: 0 0 calc(12% - 0.5rem);">
                                    <span class="tippy_ride_user cursor-default text-center w-full"
                                        data-full-name="${f.user.last_name}">
                                        ${f.user.last_name}
                                    </span>
                                </span>
                            `});let H=$(`
                        <tr
                            class="border hover:bg-theme-sub whitespace-nowrap">
                            <td class="py-1 px-2">${l.location_name}</td>
                            <td class="py-1 px-2">${l.location_memo??""}</td>
                            <td class="py-1 px-2 text-right">${l.stop_order??""}</td>
                            <td class="py-1 px-2 text-center">${x}</td>
                            <td class="py-1 px-2 text-center">
                                <div class="flex flex-row flex-wrap gap-2 justify-start">
                                    ${r}
                                </div>
                            </td>
                        </tr>
                    `);_.append(H);let E=$(`
                        <div
                            class="bg-white w-full ride-card border rounded-xl p-3 shadow-sm">
                            <div class="font-semibold">
                                ${l.location_name}
                                <span class="text-sm text-gray-600">${l.location_memo??""}</span>
                            </div>
                            <div class="text-sm text-center mt-2 font-medium">
                                ${x}
                            </div>
                            <div class="text-sm text-left mt-2 font-medium space-y-2">
                                ${r}
                            </div>
                        </div>
                    `);d.append(E)}),i.append(j),i.append(_),n.append(y),n.append(g),n.append(k),n.append(i),$("#ride_schedule_check_div").append(n).append(d),$("#ride_schedule_check_modal").removeClass("hidden")}catch{}},error:function(){alert("失敗")}})}function C(e){let t=e.departure_time?v(e.departure_time):null,a=e.arrival_time?v(e.arrival_time):null,s="";return a&&t?s=`<span class="text-orange-700 font-medium">${a} 着</span>
                    <span class="mx-1">→</span>
                    <span class="text-blue-700 font-medium">${t} 発</span>`:a?s=`<span class="text-orange-700 font-medium">${a} 着</span>`:t?s=`<span class="text-blue-700 font-medium">${t} 発</span>`:s='<span class="text-gray-400">—</span>',s}function v(e){return e?e.split(":").slice(0,2).join(":"):null}
