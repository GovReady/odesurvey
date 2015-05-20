<?php include __DIR__.'/'.'tp_pt_header.php'; ?>

<!-- Main Content Section -->
<div class="container lg-font col-md-12" style="border:0px solid black;">

 <form id="survey_form" class="form-horizontal" style="border:0px dotted black;" action="/map/survey/2du/<?php echo $content['surveyId']; ?>" method="post">

    <div class="col-md-12" role="Intro" id="role-intro">
      <div style="text-align:center;font-size:1.1em;margin-top:20px;">
        <div class="col-md-9 small">&nbsp;</div><div class="col-md-3 pull-right small" style="font-size:14px;"><a href="/map/survey/start/">English</a> | <a href="/map/survey/start/fr">Français</a> | Español</div>

        Gracias por participar en el mapa de impacto de los datos abiertos, una base de datos centralizada, con búsqueda de casos de uso de datos abiertos de todo el mundo.
        Tu contribución hace posible comprender mejor el valor de los datos abiertos y alentar el uso a nivel global.
        La información recopilada será mostrada en el mapa y hecho disponible como datos abiertos.
      </div>
      <br />
    </div>
     
    <div class="col-md-12" role="eligibility" id="role-eligibility">
      <div class="row col-md-12">
        <h4>ELEGIBILIDAD</h4>
      </div>
      <div>
        <b>El mapa de impacto de los datos abiertos incluye organizaciones que:</b>
          <ul>
              <li>son empresas, organizaciones sin fines de lucro, o grupo de programadores informáticos; y</li>
              <li>utilizan datos públicos gubernamentales para desarrollar productos y servicios, mejorar las operaciones, informar estrategia y / o realizar investigaciones.</li>
            </ul>
        Definimos los datos gubernamentales abiertos como datos públicos que son producidos o comisionados 
        por gobiernos y pueden ser accesado y reutilizado gratis por cualquiera. 
      </div>
    </div>

<br />

    <div class="col-md-12" role="orgInfo-titlebar"  id="role-orgInfo-titlebar">
      <div class="section-title"><h3>1. Información organizativa</h3></div>
    </div>

    <div class="col-md-12" role="orgInfo"  id="role-orgInfo">
      <!-- Name of organization -->
      <div class="row col-md-12">
        <div class="form-group col-md-12">
          <div class="form-group col-md-10">
            <label for="org_name">Nombre de organización<small class="required">*</small></label>
            <input type="text" class="form-control" id="org_name" name="org_name" placeholder="" required minlength="2">
        </div>
        </div>
      </div>

      <!-- Description of organization -->
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_description">Breve descripción de organización <small class="required">(máximo 400 caracteres)*</small></label>
          <textarea type="text" class="form-control " id="org_description" name="org_description" required></textarea>
        </div>
      </div>

      <!-- Type of organization -->
      <div class="form-group col-md-12" id="org_type">
          <label for="org_type">Tipo de organización<small class="required">*</small></label>
        <div class="col-md-10">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="For-profit" value="For-profit" required="True"> Comercial
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="Nonprofit" value="Nonprofit"> Sin Fines de Lucro
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="Developer group" value="Developer group"> Grupo de programadores informáticos
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="Other" value="Other"> Otro
            </label>
          </div>
        </div>
      </div>

      <!-- Website URL -->
      <div class="form-group col-md-12">
        <label for="org_url">Sitio web URL</label>
        <div class="row">      
            <div class="col-md-8">
              <input type="url" class="form-control" id="org_url" name="org_url" placeholder="http://" value="http://">
            </div>
            <div class="col-md-4">
              <input type="checkbox" name="no_org_url" id="no_org_url" value="True"> Sin URL
            </div>
        </div>
      </div>

      <!-- Location -->  
      <div class="form-group col-md-12">
        <div class="form-group col-md-10 details">

          <label for="org_hq_city_all">Localización <small class="required">(Sea lo más específico posible)*</small></label>
          <input type="text" class="form-control" id="org_hq_city_all" name="org_hq_city_all" required>

          <!--label for="org_hq_city">City</label -->
          <input type="hidden" class="form-control" id="org_hq_city" name="org_hq_city" required data-geo="locality">

          <!--label for="org_hq_st_prov">State/Province</label -->
          <input type="hidden" class="form-control" id="org_hq_st_prov" name="org_hq_st_prov" required data-geo="administrative_area_level_1">

          <!--label for="org_hq_country">Country</label -->
          <input type="hidden" class="form-control" id="org_hq_country" name="org_hq_country" required data-geo="country_short">

          <!--label for="latitude">lat</label -->
          <input type="hidden" class="form-control" id="latitude" name="latitude" required data-geo="lat">
          <!--label for="longitude">lng</label -->
          <input type="hidden" class="form-control" id="longitude" name="longitude" required data-geo="lng">
        </div>
      </div>
  
      <!-- Industry/category of organization -->
      <div class="form-group col-md-12">
        <label for="industry_id">Industria/categoría de organización <small class="required">(seleccione uno)*</small></label>
        <fieldset>
        <div class="col-md-4" id="industry_id_col-1">
          <input type="radio" name="industry_id" class="industry_id" value="Agriculture">&nbsp; Agricultura
          <br /><input type="radio" name="industry_id" class="industry_id" value="Arts and culture">&nbsp; Arte y cultura
          <br /><input id="industry_id_cul" type="radio" name="industry_id" class="industry_id" value="Business and legal services" required>&nbsp; Servicios empresariales y legales
          <br /><input type="radio" name="industry_id" class="industry_id" value="Consumer services">&nbsp; Servicios consumidor
          <br /><input type="radio" name="industry_id" class="industry_id" value="Data/information technology">&nbsp; Datos/ tecnologías de la información
          <br /><input type="radio" name="industry_id" class="industry_id" value="Education">&nbsp; Educación
          <br /><input type="radio" name="industry_id" class="industry_id" value="Energy">&nbsp; Energía
          <br /><input type="radio" name="industry_id" class="industry_id" value="Environment">&nbsp; Medio Ambiente
          <br /><input type="radio" name="industry_id" class="industry_id" value="Finance and investment">&nbsp; Finanzas e Inversiones
        </div>
        <div class="col-md-4" id="industry_id_col-2">
          <input type="radio" name="industry_id" class="industry_id" value="Geospatial/mapping">&nbsp; Geoespacial/Mapeo
          <br /><input type="radio" name="industry_id" class="industry_id" value="Governance">&nbsp; Gobierno
          <br /><input type="radio" name="industry_id" class="industry_id" value="Healthcare">&nbsp; Salud
          <br /><input type="radio" name="industry_id" class="industry_id" value="Housing and real estate">&nbsp; Vivienda/Bienes Raíces
          <br /><input type="radio" name="industry_id" class="industry_id" value="Insurance">&nbsp; Seguros
          <br /><input type="radio" name="industry_id" class="industry_id" value="Media and communications">&nbsp; Medios y Comunicación
          <br /><input type="radio" name="industry_id" class="industry_id" value="Mining/manufacturing">&nbsp; Minería/Fabricación
          <br /><input type="radio" name="industry_id" class="industry_id" value="Research and consulting">&nbsp; Investigación y Consultoría
          <br /><input type="radio" name="industry_id" class="industry_id" value="Security and public safety">&nbsp; Seguridad Pública y Vigilancia
        </div>
        <div class="col-md-4" id="industry_id_col-3">
          <input type="radio" name="industry_id" class="industry_id" value="Scientific research">&nbsp; Investigación Científica
          <br /><input type="radio" name="industry_id" class="industry_id" value="Telecommunications/internet service providers (ISPs)">&nbsp; Telecomunicaciones/proveedores de servicios de Internet
          <br /><input type="radio" name="industry_id" class="industry_id" value="Tourism">&nbsp; Turismo
          <br /><input type="radio" name="industry_id" class="industry_id" value="Transportation and logistics">&nbsp; Transporte y Logística
          <br /><input type="radio" name="industry_id" class="industry_id" value="Water and sanitation">&nbsp; Agua y Saneamiento
          <br /><input type="radio" name="industry_id" class="industry_id" value="Weather">&nbsp; Meteorológico
          <br /><input type="radio" name="industry_id" class="industry_id" value="Other">&nbsp; Otro
                <input type="text" class="form-control" style="display:none" name="industry_other" placeholder="Describe other">
        </div>
        </fieldset>
      </div>

      <!-- Founding year -->    
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_year_founded">Año de fundación<small class="required">*</small></label>
          <input type="text" class="form-control" id="org_year_founded" name="org_year_founded" placeholder="" required>
        </div>
      </div>

      <!-- Size -->
      <div class="form-group col-md-12">
        <label for="org_size_id">Número de empleados<small class="required">*</small></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="1-10"> 1-10 empleados
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="11-50"> 11-50 empleados
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="51-200"> 51-200 empleados
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="201-1000"> 201-1000 empleados
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="1000+"> 1000+ empleados
            </label>
          </div>
        </div>
      </div>

      <!-- What is the greatest type of impact your organization has? -->
      <div class="form-group col-md-12" id="org_greatest_impact">
          <label for="org_greatest_impact">¿Cuál es el tipo de impacto más grande que su organización logra?<small class="required">*</small></label>
        <div class="col-xs-9">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Economic" value="Economic" /> Económico
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Environmental" value="Environmental" /> Medio Ambiente
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Governance" value="Governance" /> Gobierno
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Social" value="Social" /> Social
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Other" value="Other" /> Otro
            </label>
          </div>
        </div>
      </div>
    </div><!--/OrgInfo-->

<br />

    <div class="col-md-12" role="dataUse-titlebar"  id="role-dataUse-titlebar">
      <div class="section-title"><h3>2. Utiliza de Datos Abiertos</h3></div>
    </div>

    <div class="col-md-12" role="dataUse" id="role-dataUse">
      
      <div class="row col-md-12 data-use-row" id="dataUseDataType">
        <label for="data_use_type[]">¿Cuales son los tipos de datos abiertos su organización utiliza que son más relevantes?<small class="required">(marque todas las opciones que apliquen)*</small></label>
        <div class="col-md-4" id="data_type_col-1">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Agriculture" required>&nbsp; <span>Agricultura</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Arts and culture">&nbsp; <span>Arte y cultura</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Business">&nbsp; <span>Empresariales</span></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Consumer">&nbsp; <span>Consumidor</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Demographics and social">&nbsp; <span>Demografía y Social</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Economics ">&nbsp; <span>Ciencias Económicas</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Education">&nbsp; <span>Educación</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Energy">&nbsp; <span>Energía</span>
        </div>
        <div class="col-md-4" id="data_type_col-2">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Environment">&nbsp; <span>Medio Ambiente</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Finance">&nbsp; <span>Finanzas</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Geospatial/mapping">&nbsp; <span>Geoespacial/mapeo</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Government operations">&nbsp; <span>Operaciones del Gobierno</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Health/healthcare">&nbsp; <span>Salud</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Housing">&nbsp; <span>Vivienda</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="International/global development">&nbsp; <span>Desarrollo Mundial</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Legal">&nbsp; <span>Legales</span>
        </div>
        <div class="col-md-4" id="data_type_col-3">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Manufacturing">&nbsp; <span>Fabricación</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Science and research">&nbsp; <span>Ciencia y Investigación</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Public safety">&nbsp; <span>Seguridad Pública</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Tourism">&nbsp; <span>Turismo</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Transportation">&nbsp; <span>Transporte</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Weather">&nbsp; <span>Meteorológico</span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Other">&nbsp; <span>Otro</span>
                  <input type="text" class="form-control" style="display:none" id="data_use_type_other" name="data_use_type_other" placeholder="Proporcione detalles">
        </div>
      </div>
<br />
      <!-- Sources of open data -->
      <div class="form-group col-md-12">
        <label for="data_country_count">¿Cuántos países proporcionan datos abiertos que su organización utiliza? <small class="required">*</small></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="1" /> 1 un país
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="2 - 5" /> 2-5 países
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="6 - 10" /> 6-10 países
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="11 - 20" /> 11-20 países
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="21 - 50" /> 21-50 países
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="50+" /> 50+ países
            </label>
          </div>
        </div>
      </div>

      <div id="data_use_details"></div>

      <div class="row col-md-12">
        <label class="row col-md-10">
          ¿Cómo su organización utiliza datos abiertos? <small class="required">(Provide as much information as possible)*</small> 
        </label>

        <div class="form-group col-md-12">
          <div class="col-md-6" id="use_open_data_col-1">
             <div>
              <input type="checkbox" class="use_open_data" name="use_advocacy" id="use_advocacy" value="True"> Promoción
              <input type="text" class="form-control" style="display:none" id="use_advocacy_desc" name="use_advocacy_desc" placeholder="Proporcione detalles">
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_prod_srvc" id="use_prod_srvc" value="True"> Desarollo de nuevos productos y servicios
              <input type="text" class="form-control" style="display:none" id="use_prod_srvc_desc" name="use_prod_srvc_desc" placeholder="Proporcione detalles">
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_org_opt" id="use_org_opt" value="True"> Optimización organizativa <i>(por ejemplo, la evaluación comparativa, análisis de mercado, mejorando la eficiencia, aumentando productos y servicios existentes)</i>
              <input type="text" class="form-control" style="display:none" id="use_org_opt_desc" name="use_org_opt_desc" placeholder="Proporcione detalles">
            </div>
          </div>

          <div class="col-md-6" id="use_open_data_col-2">
            <div>
              <input type="checkbox" class="use_open_data" name="use_research" id="use_research" value="True"> Investigación
              <input type="text" class="form-control" style="display:none" id="use_research_desc" name="use_research_desc" placeholder="Proporcione detalles">
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_other" id="use_other" value="True"> Otro
              <input type="text" class="form-control" style="display:none" id="use_other_desc" name="use_other_desc" placeholder="Proporcione detalles">
            </div>
          </div>
        </div>
      </div>

      <!-- Additional description --> 
      <div class="row col-md-12">
        <label class="row col-md-10">
          Información adicional <small class="optional">(opcional, máximo 400 caracteres)</small>
        </label>

        <div class="row col-md-10">
          <textarea type="text" class="form-control" id="org_additional" name="org_additional" placeholder="Por ejemplo, ¿cómo se podría mejorar los datos abiertos que utiliza su organización?"></textarea>
        </div>
      </div>
      <br />
    </div>

    <br />
 
    <div class="col-md-12" role="contact-titlebar"  id="role-contact-titlebar">
      <div class="section-title"><h3>3. Información de contacto <small>(ésta información no será accesible al público)</small></h3></div>
    </div>

    <div class="col-md-12" role="contact" id="role-contact">

      <div class="form-group col-md-12">
        <div class="col-md-5">
          <div for="survey_contact_first">Nombre<small class="required">*</small></div>
          <input type="text" class="form-control" id="survey_contact_first" name="survey_contact_first" required>
        </div>

        <div class="col-md-5">
          <div for="survey_contact_last">Apellido<small class="required">*</small></div>
          <input type="text" class="form-control" id="survey_contact_last" name="survey_contact_last" required>
        </div>

        <div class="col-md-10">
          <div for="survey_contact_title">Correo electrónico <i>(opcional)</i></div>
          <input type="text" class="form-control" id="survey_contact_title" name="survey_contact_title">

          <div for="survey_contact_email">Email<small class="required">*</small></div>
          <input type="email" class="form-control" id="survey_contact_email" name="survey_contact_email" required>

          <div for="survey_contact_email">Teléfono <i>(opcional)</i></div>
          <input type="text" class="form-control" id="survey_contact_phone" name="survey_contact_phone">

          <input type="hidden" class="form-control" id="org_profile_year" name="org_profile_year" value="2015">
          <input type="hidden" class="form-control" id="org_profile_status" name="org_profile_status" value="submitted">
          <input type="hidden" class="form-control" id="org_profile_src" name="org_profile_src" value="survey">
          <input type="hidden" class="form-control" id="org_profile_src" name="org_profile_category" value="submitted survey">
        </div>
      </div>
    </div><!-- /closes role contact -->
      
      <br />

    <div class="col-md-12" role="submit-note" id="role-submit-note">
      <div style="text-align:center;font-size:16px;margin-top:20px;">
        <b><i>Toda la información recopilada sera revisada antes de su exhibición pública en el mapa de impacto de los datos abiertos.</i></b>
      </div>
      <br />
    </div>

    <div class="col-md-12" style="text-align:center;">    
      <button class="btn btn-primary" style="padding:1em 2em 1em 2em; width:200px; background-color: rgb(53, 162, 227);" id="btnSubmit" type="submit" name="submit" value="submit">ENVIAR</button>
    </div>

      
    </div>

</form>

</div> 
<!-- I think I am missing a closing </div> gut things are working. -->
<!-- end container - where is the tag? -->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>

