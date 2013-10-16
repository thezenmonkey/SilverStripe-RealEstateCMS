<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
		<div>
			<h2>$ClassName</h2>
			<p>
			<% if $Status %>Status: $Status<br><% end_if %>
			<% if $Feature %>Feature: $Feature<br><% end_if %>
			<% if $IsNew %>IsNew: $IsNew<br><% end_if %>
			<% if $MLS %>MLS: $MLS<br><% end_if %>
			<% if $Type %>Type: $Type<br><% end_if %>
			<% if $SaleOrRent %>SaleOrRent: $SaleOrRent<br><% end_if %>
			</p>
			<h3>Basic Address Data</h3>
			<p>
			<% if $Address %>Address: $Address<br><% end_if %>
			<% if $Unit %>Unit: $Unit<br><% end_if %>
			<% if $Town %>Town: $Town<br><% end_if %>
			<% if $PostalCode %>PostalCode: $PostalCode<br><% end_if %>
			<% if $Street %>Street (generated from address field): $Street<br><% end_if %>
			</p>
			<h3>basic home details</h3>
			<p>
			<% if $TotalArea %>TotalArea: $TotalArea<br><% end_if %>
			<% if $NumberBed %>NumberBed: $NumberBed<br><% end_if %>
			<% if $NumberBath %>NumberBath: $NumberBath<br><% end_if %>
			<% if $NumberRooms %>NumberRooms: $NumberRooms<br><% end_if %>
			</p>
			<h3>basic financial data</h3>
			<p>
			<% if $Price %>Price: $Price<br><% end_if %>
			<% if $Taxes %>Taxes: $Taxes<br><% end_if %>
			<% if $TaxYear %>TaxYear: $TaxYear<br><% end_if %>
			<% if $HideMonthly %>HideMonthly: $HideMonthly<br><% end_if %>
			</p>
			<h3>lot size</h3>
			<p>
			<% if $LotLength %>LotLength: $LotLength<br><% end_if %>
			<% if $LotWidth %>LotWidth: $LotWidth<br><% end_if %>
			<% if $LotAcreage %>LotAcreage: $LotAcreage<br><% end_if %>
			<% if $Irregular %>Irregular: $Irregular<br><% end_if %>
			</p>
			<h3>Content Fields</h3>
			<p>
			<% if $Headline %>Headline: $Headline<br><% end_if %>
			<% if $Summary %>Summary: $Summary<br><% end_if %>
			</p>
			<h3>mapping data</h3>
			<p>
			<% if $Lat %>Lat: $Lat<br><% end_if %>
			<% if $Lon %>Lon: $Lon<br><% end_if %>
			<% if $SVHeading %>SVHeading: $SVHeading<br><% end_if %>
			<% if $SVPitch %>SVPitch: $SVPitch<br><% end_if %>
			<% if $SVZoom %>SVZoom: $SVZoom<br><% end_if %>
			</p>
			<h3>feature sheet data</h3>
			<p>
			<% if $AdditionalMLS %>AdditionalMLS: $AdditionalMLS<br><% end_if %>
			<% if $KeyPoints %>KeyPoints: $KeyPoints<br><% end_if %>
			<% if $Vendors %>Vendors: $Vendors<br><% end_if %>
			<% if $Possession %>Possession: $Possession<br><% end_if %>
			<% if $Lockbox %>Lockbox: $Lockbox<br><% end_if %>
			<% if $Fireplaces %>Fireplaces: $Fireplaces<br><% end_if %>
			<% if $Garage %>Garage: $Garage<br><% end_if %>
			<% if $Driveway %>Driveway: $Driveway<br><% end_if %>
			<% if $District %>District: $District<br><% end_if %>
			<% if $Occupied %>Occupied: $Occupied<br><% end_if %>
			<% if $AC %>AC: $AC<br><% end_if %>
			<% if $Heat %>Heat: $Heat<br><% end_if %>
			<% if $Basement %>Basement: $Basement<br><% end_if %>
			<% if $Construction %>Construction: $Construction<br><% end_if %>
			<% if $Topography %>Topography: $Topography<br><% end_if %>
			<% if $Age %>Age: $Age<br><% end_if %>
			<% if $Water %>Water: $Water<br><% end_if %>
			<% if $Sewer %>Sewer: $Sewer<br><% end_if %>
			<% if $Restrictions %>Restrictions: $Restrictions<br><% end_if %>
			<% if $Zoning %>Zoning: $Zoning<br><% end_if %>
			<% if $LegalDesc %>LegalDesc: $LegalDesc<br><% end_if %>
			<% if $Deposit %>Deposit: $Deposit<br><% end_if %>
			<% if $SideOfRoad %>SideOfRoad: $SideOfRoad<br><% end_if %>
			<% if $ListingDate %>ListingDate: $ListingDate<br><% end_if %>
			<% if $Mortgage %>Mortgage: $Mortgage<br><% end_if %>
			</p>
			<h3>Media</h3>
			<p>
			<% if $Folder %>Folder: ID $Folder.ID $Folder.Name<br><% end_if %>
			<% if $VideoURL %>VideoURL: $VideoURL<br>
			Video URL Embed<br>
			<% end_if %>
			<% if $Featuresheet %>Featuresheet: $Featuresheet.Filename<br><% end_if %>
			</p>
			<% if $Floorplans %>
			<h4>Floorplans</h4>
			<ul>
				<% loop $Floorplans %>
				<li>$Title  $CMSThumbnail</li>
				<% end_loop %>
			</ul>
			<% end_if %>
			<% if $Images %>
			<h4>Images</h4>
			<ul>
				<% loop $Images %>
				<li>$CMSThumbnail</li>
				<% end_loop %>
			</ul>
			<% end_if %>
			<h3>Extra Listing Relations</h3>
			<p>
				City: <% if $City %>$City.Title<% else %>No City<% end_if %><br>
				Neighbourhood: <% if $Neighbourhood %>$Neighbourhood.Title<% else %>No Neighbourhood<% end_if %><br>
			</p>
			<% if $Shools %>
			<h4>Schools</h4>
			<ul>
				<% loop $Schools %>
				<li>$Name</li>
				<% end_loop %>
			</ul>
			<% end_if %>
			<% if $Rooms %>
			<h4>Rooms</h4>
			<ol>
				<% loop $Rooms %>
				<li>$Name</li>
				<% end_loop %>
			</ol>
			<% else %>
			no rooms<br>
			<% end_if %>
			<% if $OpenHouseDates %>
			<h4>Open House Dates</h4>
			<ol>
				<% loop $OpenHouseDates %>
				<li>$OpenHouseDate</li>
				<% end_loop %>
			</ol>
			<% else %>
			no open house dates<br>
			<% end_if %>
			<h3>Template Functions</h3>
			<p>
				Formatted Price: $FormattedPrice<br>
				Formatted Taxes: $FormattedTaxes<br>
				Monthly Price based on Mortgage Settings: $MonthlyPrice<br>
				Down Payment: $DownPayment<br>
			</p>
			<% if $UpcomingOpenHouse %>
			<h4>Upcoming Open House Dates</h4>
			<ol>
				<% loop $UpcomingOpenHouse %>
				<li>$OpenHouseDate</li>
				<% end_loop %>
			</ol>
			<% else %>
			no upcoming open house dates<br>
			<% end_if %>
			<% if $NextOpenHouse %>
			<h4>Next Open house Date</h4>
			$NextOpenHouse<br>
			<% else %>
			no next open house date<br>
			<% end_if %>
		</div>
	</article>
		$Form
		$PageComments
</div>