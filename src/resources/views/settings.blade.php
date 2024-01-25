@extends('web::layouts.grids.6-6')

@section('title', trans('billing::billing.settings'))
@section('page_header', trans('billing::billing.settings'))

@section('left')
    @include("treelib::giveaway")

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ trans('billing::billing.settings') }}</h3>
        </div>
        <form method="POST" action="{{ route('billing.savesettings')  }}" class="form-horizontal">
            <div class="card-body">
                @csrf

                <h4>{{ trans('billing::settings.basic_settings_header') }}</h4>

                <div class="form-group">
                    <label for="oremodifier">{{ trans('billing::settings.ore_value_modifier_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="oremodifier" id="oremodifier"
                               value="{{ setting('oremodifier', true) }}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="refinerate">{{ trans('billing::settings.ore_refining_rate_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="refinerate" id="refinerate" size="4"
                               value="{{ setting('refinerate', true) }}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="bountytaxrate">{{ trans('billing::settings.bounty_tax_rate_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="bountytaxrate" id="bountytaxrate"
                               value="{{ setting('bountytaxrate', true) }}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <hr>

                <h4>{{ trans('billing::settings.incentive_settings_header') }}</h4>

                <div class="form-group">
                    <label for="ioremodifier">{{ trans('billing::settings.incentive_ore_value_modifier_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="ioremodifier" id="ioremodifier"
                               value="{{ setting('ioremodifier', true) }}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ioretaxmodifier">{{ trans('billing::settings.incentive_ore_refining_rate_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="ioretaxmodifier" id="ioretaxmodifier"
                               value="{{ setting('ioretaxmodifier', true) }}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ibountytaxmodifier">{{ trans('billing::settings.incentive_bounty_tax_rate_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="ibountytaxmodifier" id="ibountytaxmodifier"
                               value="{{ setting('ibountytaxmodifier', true) }}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="irate">{{ trans('billing::settings.rate_threshold_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="irate" id="irate"
                               value="{{ setting('irate', true) }}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <hr/>

                <h4>{{ trans('billing::settings.valuation_of_ore_header') }}</h4>

                <div class="form-group">
                    <label>{{ trans('billing::settings.valuation_mode_label') }}</label>
                    @if (setting('pricevalue', true) == "m")
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pricevalue" id="pricevalue1" value="o">
                            <label class="form-check-label" for="pricevalue1">
                                {{ trans('billing::settings.value_at_ore_price_label') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pricevalue" id="pricevalue2" value="m"
                                   checked>
                            <label class="form-check-label" for="pricevalue2">
                                {{ trans('billing::settings.value_at_mineral_price_label') }}
                            </label>
                        </div>
                    @else
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pricevalue" id="pricevalue1" value="o"
                                   checked>
                            <label class="form-check-label" for="pricevalue1">
                                {{ trans('billing::settings.value_at_ore_price_label') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pricevalue" id="pricevalue2" value="m">
                            <label class="form-check-label" for="pricevalue2">
                                {{ trans('billing::settings.value_at_mineral_price_label') }}
                            </label>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Price Source</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pricesource" id="pricesource1"
                               value="sell_price" @checked(setting("price_source", true)==="sell_price")>
                        <label class="form-check-label" for="pricesource1">
                            {{ trans('billing::settings.value_at_sell_price_label') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pricesource" id="pricesource2"
                               value="buy_price" @checked(setting("price_source", true)==="buy_price")>
                        <label class="form-check-label" for="pricesource2">
                            {{ trans('billing::settings.value_at_buy_price_label') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pricesource" id="pricesource3"
                               value="adjusted_price" @checked(setting("price_source", true)==="adjusted_price")>
                        <label class="form-check-label" for="pricesource3">
                            {{ trans('billing::settings.value_at_ccp_price_label') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pricesource" id="pricesource4"
                               value="average_price" @checked(setting("price_source", true)==="average_price")>
                        <label class="form-check-label" for="pricesource4">
                            {{ trans('billing::settings.value_at_ccp_market_price_label') }}
                        </label>
                    </div>
                </div>

                <hr>

                <h4>{{ trans('billing::settings.ore_tax_header') }}</h4>

                <div class="form-group">
                    <label for="r64taxmodifier">{{ trans('billing::settings.r64_tax_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="r64taxmodifier" id="r64taxmodifier"
                               value="{{ $ore_tax->firstWhere("group_id",1923)->tax_rate ?? 0}}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="r32taxmodifier">{{ trans('billing::settings.r32_tax_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="r32taxmodifier" id="r32taxmodifier"
                               value="{{ $ore_tax->firstWhere("group_id",1922)->tax_rate ?? 0}}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="r16taxmodifier">{{ trans('billing::settings.r16_tax_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="r16taxmodifier" id="r16taxmodifier"
                               value="{{ $ore_tax->firstWhere("group_id",1921)->tax_rate ?? 0}}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="r8taxmodifier">{{ trans('billing::settings.r8_tax_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="r8taxmodifier" id="r8taxmodifier"
                               value="{{ $ore_tax->firstWhere("group_id",1920)->tax_rate ?? 0}}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="r4taxmodifier">{{ trans('billing::settings.r4_tax_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="r4taxmodifier" id="r4taxmodifier"
                               value="{{ $ore_tax->firstWhere("group_id",1884)->tax_rate ?? 0}}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="gastax">{{ trans('billing::settings.gas_tax_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="gastax" id="gastax"
                               value="{{ $ore_tax->firstWhere("group_id",711)->tax_rate ?? 0}}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="icetax">{{ trans('billing::settings.ice_tax_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="icetax" id="icetax"
                               value="{{ $ore_tax->firstWhere("group_id",465)->tax_rate ?? 0}}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="oretaxrate">{{ trans('billing::settings.other_ores_tax_label') }}</label>
                    <div class="d-flex flex-row align-items-baseline">
                        <input class="form-control" type="number" name="oretaxrate" id="oretaxrate" size="4"
                               value="{{ setting('oretaxrate', true) }}"/>
                        <div class="pl-2">%</div>
                    </div>
                </div>

                <hr>
                <h4>{{ trans("billing::billing.tax_invoices") }}</h4>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tax_invoices" id="tax_invoices1"
                               value="enabled" @checked(\Denngarr\Seat\Billing\BillingSettings::$GENERATE_TAX_INVOICES->get(false)===true)>
                        <label class="form-check-label" for="tax_invoices1">
                            {{ trans("billing::billing.enable_tax_invoices_label") }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tax_invoices" id="tax_invoices2"
                               value="disabled" @checked(\Denngarr\Seat\Billing\BillingSettings::$GENERATE_TAX_INVOICES->get(false)===false)>
                        <label class="form-check-label" for="tax_invoices2">
                            {{ trans("billing::billing.disable_tax_invoices_label") }}
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="whiteListCorps">{{ trans("billing::billing.corporation_whitelist_label") }}</label>
                    <small>{{ trans("billing::billing.corporation_whitelist_desc") }}</small>
                    <textarea class="form-control" rows="7" style="resize: none;" id="whiteListCorps"
                              name="tax_invoices_whitelist" placeholder="Doomheim&#10;C C P">{{$whitelist}}</textarea>
                </div>

                <div class="form-group">
                    <label for="whiteListCorps">{{ trans("billing::billing.invoice_threshold_label") }}</label>
                    <small>{{ trans("billing::billing.invoice_threshold_desc") }}</small>
                    <input type="number" class="form-control" name="invoice_threshold"
                           value="{{ \Denngarr\Seat\Billing\BillingSettings::$INVOICE_THRESHOLD->get(0) }}">
                </div>

                <div class="form-group">
                    <label for="holdingCorps">{{ trans("billing::billing.holding_corps_label") }}</label><br>
                    <small>
                        {!! trans("billing::billing.holding_corps_desc") !!}
                    </small>
                    <textarea class="form-control" rows="7" style="resize: none;" id="holdingCorps"
                              name="tax_invoice_holding_corps"
                              placeholder="Doomheim -> C C P">{{$tax_receiver_corps??''}}</textarea>
                </div>

                <div class="form-group">
                    <label>{{ trans("billing::billing.tax_code_visibility") }}</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tax_codes" id="tax_codes1"
                               value="disabled" @checked(\Denngarr\Seat\Billing\BillingSettings::$ALWAYS_SHOW_TAX_CODES->get(false)===false)>
                        <label class="form-check-label" for="tax_codes1">
                            {!! trans("billing::billing.tax_code_visibility_desc") !!}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tax_codes" id="tax_codes2"
                               value="enabled" @checked(\Denngarr\Seat\Billing\BillingSettings::$ALWAYS_SHOW_TAX_CODES->get(false)===true)>
                        <label class="form-check-label" for="tax_codes2">
                            {{ trans("billing::billing.always_show_tax_codes_label") }}
                            <small class="text-muted">{{ trans("billing::billing.always_show_tax_codes_desc") }}</small>
                        </label>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <input class="btn btn-success pull-right" type="submit"
                       value="{{ trans("billing::billing.update_btn") }}">
            </div>
        </form>

    </div>
@endsection

@section('right')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ trans('billing::billing.settings') }}</h3>
        </div>
        <div class="card-body">
            <div class="col-sm-12">
                <label>{{ trans('billing::settings.ore_value_modifier_label') }}:</label>
                <p>
                    {{ trans('billing::settings.ore_value_modifier_desc') }}
                </p>
            </div>
            <div class="col-sm-12">
                <label>{{ trans('billing::settings.ore_refining_rate_label') }}:</label>
                <p>
                    {{ trans('billing::settings.ore_refining_rate_desc') }}
                </p>
            </div>
            <div class="col-sm-12">
                <label>{{ trans('billing::settings.bounty_tax_rate_label') }}:</label>
                <p>
                    {{ trans('billing::settings.bounty_tax_rate_desc') }}
                </p>
            </div>
            <div class="col-sm-12">
                <label>{{ trans('billing::settings.incentive_settings_header') }}:</label>
                <p>
                    {{ trans('billing::settings.incentive_settings_desc') }}
                </p>
            </div>
            <div class="col-sm-12">
                <label>{{ trans('billing::settings.incentive_ore_value_modifier_label') }}:</label>
                <p>
                    {{ trans('billing::settings.incentive_ore_value_modifier_desc') }}
                </p>
            </div>
            <div class="col-sm-12">
                <label>{{ trans('billing::settings.incentive_ore_refining_rate_label') }}:</label>
                <p>
                    {{ trans('billing::settings.incentive_ore_refining_rate_desc') }}
                </p>
            </div>
            <div class="col-sm-12">
                <label>{{ trans('billing::settings.incentive_bounty_tax_rate_label') }}:</label>
                <p>
                    {{ trans('billing::settings.incentive_bounty_tax_rate_desc') }}
                </p>
            </div>
            <div class="col-sm-12">
                <label>{{ trans('billing::settings.rate_threshold_label') }}:</label>
                <p>
                    {{ trans('billing::settings.rate_threshold_desc') }}
                </p>
            </div>
            <div class="col-sm-12">
                <label>{{ trans('billing::settings.valuation_of_ore_header') }}:</label>
                <p>
                    {{ trans('billing::settings.valuation_of_ore_desc') }}
                </p>
            </div>
            <div class="col-sm-12">
                <label>{{ trans('billing::settings.ore_tax_header') }}:</label>
                <p>
                    {{ trans('billing::settings.ore_tax_desc') }}
                </p>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script>

    </script>
@endpush
