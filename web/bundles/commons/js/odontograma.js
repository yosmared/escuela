//View Models
function DienteModel(id, x, y, isAdult){
	var self = this;

	self.id = id;	
	self.x = x;
	self.y = y;
	self.isAdult = isAdult;
};

function ViewModel(){
	var self = this;

	self.dienteSeleccionado = ko.observable(null);
	self.diagnosticosAplicados = ko.observableArray([]);

	self.quitarDiagnostico = function(diagnostico){
		self.diagnosticosAplicados.remove(diagnostico);
		renderSvg(adult, odontogramReadOnly);
		
		// hay que recorrer los inputs y comparar con el objeto diagnostico y eliminarlo		
		$(':input.form-control-teethid').each(function(){
			var inputTeethId = $(this).attr('id');
			var inputId = inputTeethId.replace(/_teethid_id/g, '_id');
			var inputTeethRegionId = inputTeethId.replace(/_teethid_id/g, '_teethregionid_abbreviation');
			var inputDiagnosticsId = inputTeethId.replace(/_teethid_id/g, '_diagnosticsid_name');
			
			var inputTeethIdVal = $('#' + inputTeethId).val();
			var inputTeethRegionIdVal = $('#' + inputTeethRegionId).val();
			var inputDiagnosticsIdVal = $('#' + inputDiagnosticsId).val();

			if (inputTeethIdVal == diagnostico.diente.id && 
					inputTeethRegionIdVal == diagnostico.cara &&
					inputDiagnosticsIdVal == diagnostico.diagnostico) {
				$('#' + inputId).each(function() {
				    $(this).remove();
				});
				$('#' + inputTeethId).each(function() {
				    $(this).remove();
				});
				$('#' + inputTeethRegionId).each(function() {
				    $(this).remove();
				});	
				$('#' + inputDiagnosticsId).each(function() {
				    $(this).remove();
				});	
			}
		});
	};

	//Cargo los dientes
	var dientes = [];
	//Dientes izquierdos
	for(var i = 0; i < 8; i++){
		dientes.push(new DienteModel(18 - i, i * 25, 0, 1));
	}
	for(var i = 3; i < 8; i++){
		dientes.push(new DienteModel(58 - i, i * 25, 0, 0));
	}
	for(var i = 3; i < 8; i++){
		dientes.push(new DienteModel(88 - i, i * 25, 1 * 50, 0));
	}
	for(var i = 0; i < 8; i++){
		dientes.push(new DienteModel(48 - i, i * 25, 1 * 50, 1));
	}
	//Dientes derechos
	for(var i = 0; i < 8; i++){
		dientes.push(new DienteModel(21 + i, i * 25 + 210, 0, 1));
	}
	for(var i = 0; i < 5; i++){
		dientes.push(new DienteModel(61 + i, i * 25 + 210, 0, 0));
	}
	for(var i = 0; i < 5; i++){
		dientes.push(new DienteModel(71 + i, i * 25 + 210, 1 * 50, 0));
	}
	for(var i = 0; i < 8; i++){
		dientes.push(new DienteModel(31 + i, i * 25 + 210, 1 * 50, 1));
	}

	self.dientes = ko.observableArray(dientes);
};

function renderSvg(isAdulto, isReadOnly){
	var svg = $('#odontograma').svg('get').clear();
	var parentGroup = svg.group({transform: 'scale(1.4)'});
	var dientes = vm.dientes(); 
	for (var i =  dientes.length - 1; i >= 0; i--) {
		var diente =  dientes[i];
		var dienteUnwrapped = ko.utils.unwrapObservable(diente); 
		drawDiente(svg, parentGroup, dienteUnwrapped, isAdulto, isReadOnly);
	}
	
	if (!isReadOnly) {
		linguales = $('#odontogram_lingualesText').val();
	}
	//console.log("linguales:"+ linguales);
	var lingualesX = 178;
	if (linguales.length == 7) {
		lingualesX = 185;
	}
	svg.line(parentGroup, 202.5, 0, 202.5, 30, {stroke: 'navy', strokeWidth: 1});
	svg.line(parentGroup, 202.5, 45, 202.5, 80, {stroke: 'navy', strokeWidth: 1});
	svg.text(parentGroup, lingualesX, 42, linguales.toUpperCase(), {fill: 'navy', stroke: 'navy', strokeWidth: 0.1, style: 'font-size: 7pt;font-weight:normal;'});
	svg.line(parentGroup, 0, 39, 175, 39, {stroke: 'navy', strokeWidth: 1});
	svg.line(parentGroup, 233, 39, 405, 39, {stroke: 'navy', strokeWidth: 1});
};

function drawDiente(svg, parentGroup, diente, adulto, isReadOnly) {
	if(!diente) {
		throw new Error('Error no se ha especificado el diente.');
	}

	var x = diente.x || 0;
	var y = diente.y || 0;
	var opacidad = 'none';
	if (adulto == diente.isAdult) {
		opacidad = 'show';
	}

	var defaultPolygon = {fill: 'white', stroke: 'navy', strokeWidth: 0.5};
	var dienteGroup = svg.group(parentGroup, {transform: 'translate(' + x + ',' + y + ')', display: opacidad});

	var caraSuperior = svg.polygon(dienteGroup,	[[0,0],[20,0],[15,5],[5,5]], defaultPolygon);
	caraSuperior = $(caraSuperior).data('cara', 'S');

	var caraInferior =  svg.polygon(dienteGroup, [[5,15],[15,15],[20,20],[0,20]], defaultPolygon);
	caraInferior = $(caraInferior).data('cara', 'I');

	var caraDerecha = svg.polygon(dienteGroup, [[15,5],[20,0],[20,20],[15,15]], defaultPolygon);
	caraDerecha = $(caraDerecha).data('cara', 'D');

	var caraIzquierda = svg.polygon(dienteGroup, [[0,0],[5,5],[5,15],[0,20]], defaultPolygon);
	caraIzquierda = $(caraIzquierda).data('cara', 'Z');

	var caraCentral = svg.polygon(dienteGroup, [[5,5],[15,5],[15,15],[5,15]], defaultPolygon);	
	caraCentral = $(caraCentral).data('cara', 'C');

	var caraCompletoStyle = 'font-size: 7pt;font-weight:normal;';
	if (!isReadOnly) {
		caraCompletoStyle = 'font-size: 7pt;font-weight:normal; cursor: pointer;';
	}
	var caraCompleto = svg.text(dienteGroup, 6, 30, diente.id.toString(), {fill: 'navy', stroke: 'navy', strokeWidth: 0.1, style: caraCompletoStyle});
	caraCompleto = $(caraCompleto).data('cara', 'X');

	//Busco los diagnosticos aplicados al diente
	var diagnosticosAplicadosAlDiente = ko.utils.arrayFilter(vm.diagnosticosAplicados(), function(t){
		return t.diente.id == diente.id;
	});

	var caras = [];
	caras['S'] = caraSuperior;
	caras['I'] = caraInferior;
	caras['C'] = caraCentral;
	caras['X'] = caraCompleto;
	caras['Z'] = caraIzquierda;
	caras['D'] = caraDerecha;

	for (var i = diagnosticosAplicadosAlDiente.length - 1; i >= 0; i--) {
		var t = diagnosticosAplicadosAlDiente[i];
		caras[t.cara].attr('fill', 'red');
	};

	if (!isReadOnly) {
		$.each([caraCentral, caraIzquierda, caraDerecha, caraInferior, caraSuperior, caraCompleto], function(index, value){
			value.click(function(){
				var me = $(this);
				var cara = me.data('cara');

				// validando si esa region del diente ha sido ya agregada
				var dienteVal = diente.id + cara;
				var alreadySelected = toothDiagnosisAdded(dienteVal, true);			
				if (!alreadySelected) {
					var ds = vm.dienteSeleccionado;
					if (ds != null) {
						var oldSelected = ds.me;
						if (oldSelected != null) {
							if (ds.cara == 'X') {
								oldSelected.attr('fill', 'navy');
							} else {
								oldSelected.attr('fill', 'white');
							}
						}
					}

					$("#diente").val(diente.id + cara);
					vm.dienteSeleccionado = {diente: diente, cara: cara, me: me};
					me.attr('fill', 'yellow');
					$("#diagnostico").focus();
				}
			}).mouseenter(function(){
				var me = $(this);

				// validando si esa region del diente ha sido ya agregada
				var cara = me.data('cara');
				var dienteVal = diente.id + cara;
				var alreadySelected = toothDiagnosisAdded(dienteVal, false);			
				if (!alreadySelected) {
					me.data('oldFill', me.attr('fill'));
					me.attr('fill', 'CornflowerBlue');
				}
			}).mouseleave(function(){
				var me = $(this);
				var ds = vm.dienteSeleccionado;
				if (ds != null && ds.diente != null && diente.id == ds.diente.id && me.data('cara') == ds.cara) {
					me.attr('fill', 'yellow');
				} else {
					me.attr('fill', me.data('oldFill'));
				}
			});
		});
	}
}

function selectTooth() {
	var dienteInput = $("#diente").val();
	var founded = false;
	if (dienteInput.length == 3) {
		var id = dienteInput.substring(0,2);
		var cara = dienteInput.substring(2,3).toUpperCase();

		var caras = ["S", "I", "C", "X", "Z", "D"];
		var iCaras = caras.indexOf(cara);
		if (iCaras != -1) {
			var dientes = vm.dientes();
			for (var i =  dientes.length - 1; i >= 0; i--) {
				var diente =  dientes[i];
				if (id == diente.id) {
					if (diente.isAdult == adult) {
						var alreadySelected = toothDiagnosisAdded(dienteInput, true);

						if (!alreadySelected) {
							vm.dienteSeleccionado = {diente: diente, cara: cara};
							$("#diente").val(id + cara);
							founded = true;
							break;
						}
					}
				}
			}
		}
	}
	if (!founded) {
		$("#diente").val("");
	}
}

function toothDiagnosisAdded(toothDiagnosis, alertModal) {
	var retorno = false;
	var da = ko.utils.arrayFilter(vm.diagnosticosAplicados(), function(t){
		return true;
	});
	for (var i = da.length - 1; i >= 0; i--) {
		var t = da[i];
		tDienteCara = t.diente.id + t.cara;
		if (toothDiagnosis == tDienteCara) {
			retorno = true;
			break;
		}
	};
	if(retorno && alertModal) {
		$('#alertModal').modal();
	}
	return retorno;
}

function addDiagnosis() {
	var dienteSeleccionado = vm.dienteSeleccionado;
	var dienteVal = $("#diente").val().trim();

	var ms = $('#ms').magicSuggest({});
	var diagnostico = ms.getValue();
	
	if (dienteVal.length > 0 &&
			dienteSeleccionado != null && 
			diagnostico.length > 0) {

		var alreadySelected = toothDiagnosisAdded(dienteVal, true);
		
		if (!alreadySelected) {
			vm.diagnosticosAplicados.push({diente: dienteSeleccionado.diente, cara: dienteSeleccionado.cara, diagnostico: diagnostico});
			vm.dienteSeleccionado = null;
			$("#diente").val("");
			ms.clear();
			renderSvg(adult);
			
			var prototypeHolder = $('#odontogramsPrototype');
			var divHolder = $('#odontogramsForm');
			
			var prototype = prototypeHolder.data('prototype-teeth');
			var newForm = prototype.replace(/odontogramid___name___/g, 'odontogramid_0_');
			newForm = newForm.replace(/___name___teethid_id/g, '_'+ indexInput + '_teethid_id');
			newForm = newForm.replace(/___name___teethregionid_abbreviation/g, '_'+ indexInput + '_teethregionid_abbreviation');
			newForm = newForm.replace(/___name___diagnosticsid_name/g, '_'+ indexInput + '_diagnosticsid_name');
			newForm = newForm.replace(/\[odontogramid\]\[__name__\]/g, '[odontogramid][0]');
			newForm = newForm.replace(/\[__name__\]\[teethid\]/g, '[' + indexInput + '][teethid]');
			newForm = newForm.replace(/\[__name__\]\[teethregionid\]/g, '[' + indexInput + '][teethregionid]');
			newForm = newForm.replace(/\[__name__\]\[diagnosticsid\]/g, '[' + indexInput + '][diagnosticsid]');
			newForm = newForm.replace(/class=\"form-control-teethid\"/g, 'value="' + dienteSeleccionado.diente.id + '" class="form-control-teethid"');
			newForm = newForm.replace(/class=\"form-control-teethregionid\"/g, 'value="' + dienteSeleccionado.cara + '" class="form-control-teethregionid"');
			newForm = newForm.replace(/class=\"form-control-diagnosticsid\"/g, 'value="' + diagnostico + '" class="form-control-diagnosticsid"');
			divHolder.append(newForm);
			indexInput++;			
		} else {
			$('#alertModal').modal();
		}
	}
}

function initDiagnosis() {
	var divHolder = $('#odontogramsForm');
	var inputLength = divHolder.find(':input.form-control-teethid').length;

	var j = 0;
	for (j; j<inputLength;j++) { 
		var inputTeeth = $('#odontogram_odontogramteethid_' + j + '_teethid_id');
		var inputTeetRegion =  $('#odontogram_odontogramteethid_' + j + '_teethregionid_abbreviation');
		var inputDiagnostics = $('#odontogram_odontogramteethid_' + j + '_diagnosticsid_name');
		
		var diente;
		var dientes = vm.dientes();
		for (var i =  dientes.length - 1; i >= 0; i--) {
			if (dientes[i].id == inputTeeth.val()) {
				diente = dientes[i];
				vm.diagnosticosAplicados.push({diente: diente, cara: inputTeetRegion.val(), diagnostico: inputDiagnostics.val()});
				break;
			}
		}
	}
	indexInput = j;
}

//Inicializo SVG
$('#odontograma').svg({
	settings:{ width: '620px', height: '120px' }
});
vm = new ViewModel();
ko.applyBindings(vm);
var adult;
var indexInput;
var odontogramReadOnly;

$(document).ready(function() {
	
	var modalConfirmed = false;
	$("input[name='odontogram[isadult]']").change(function(e) {
		modalConfirmed = false;
		$('#confirmModalSingle').modal();
	});

	$('#confirmModalSingle #btn-confirm').click (function(){
		modalConfirmed = true;
		$("#confirmModalSingle").modal("hide");
		var adultRadioOpt = $("input[id='odontogram_isadult_0']:checked").val();
		adult = 0;

		if (adultRadioOpt == 1) {
			adult = 1;
		}
		vm.diagnosticosAplicados.removeAll();
		$("#diente").val("");
		var ms = $('#ms').magicSuggest({});
		ms.clear();
		$('#odontogramsForm').empty();
		renderSvg(adult);
	});
	$('#confirmModalSingle').on('hidden.bs.modal', function () {
		  if (!modalConfirmed) {
				var adultRadioOpt = $("input[id='odontogram_isadult_0']:checked").val();
				if (adultRadioOpt == 1) {
					$("input[id='odontogram_isadult_1']").prop('checked', true);
					adult = 0;
				} else {
					$("input[id='odontogram_isadult_0']").prop('checked', true);
					adult = 1;
				}
		  }
	});

	$("#diente").blur(function() {
		selectTooth();
	});
	
	$("#diente").keydown(function(e){
		if(e.which == 13) {//Enter key pressed
			selectTooth();
			return false;
		}
	});

	$("#add_diagnosis").click(function() {
		addDiagnosis();
	});
	
	$("#diagnostico").keydown(function(e){
		if(e.which == 13) {//Enter key pressed
			addDiagnosis();
			return false;
		}
	});

	$("#ayuda").mouseenter(function(){
		$('.toolTipText').show('slow');
	}).mouseleave(function(){
		$('.toolTipText').hide('slow');
	});
});
