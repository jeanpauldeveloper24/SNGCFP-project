import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class ConventionForm extends StatefulWidget {
  final Function(String type, String montant) onSaved; // Le callback indispensable

  const ConventionForm({super.key, required this.onSaved});

  @override
  State<ConventionForm> createState() => _ConventionFormState();
}

class _ConventionFormState extends State<ConventionForm> {
  final _formKey = GlobalKey<FormState>();
  final TextEditingController _montantController = TextEditingController();
  String? selectedType;
  final List<String> types = ['DRF (Demande de Retrait de Fonds)', 'DPD (Demande de Paiement Direct)'];

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: const BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
      ),
      padding: EdgeInsets.only(
        bottom: MediaQuery.of(context).viewInsets.bottom + 20,
        top: 20, left: 20, right: 20,
      ),
      child: Form(
        key: _formKey,
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Text("Nouvelle Demande", style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold)),
            const SizedBox(height: 20),
            DropdownButtonFormField<String>(
              value: selectedType,
              decoration: const InputDecoration(labelText: "Type", border: OutlineInputBorder()),
              items: types.map((t) => DropdownMenuItem(value: t, child: Text(t))).toList(),
              onChanged: (v) => setState(() => selectedType = v),
              validator: (v) => v == null ? "Requis" : null,
            ),
            const SizedBox(height: 15),
            TextFormField(
              controller: _montantController,
              keyboardType: TextInputType.number,
              decoration: const InputDecoration(labelText: "Montant (FCFA)", border: OutlineInputBorder()),
              validator: (v) => v!.isEmpty ? "Requis" : null,
            ),
            const SizedBox(height: 25),
            SizedBox(
              width: double.infinity,
              height: 50,
              child: ElevatedButton(
                onPressed: () {
                  if (_formKey.currentState!.validate()) {
                    // On envoie les données à la page parente via le callback
                    widget.onSaved(selectedType!, _montantController.text);
                    Navigator.pop(context);
                  }
                },
                style: ElevatedButton.styleFrom(backgroundColor: const Color(0xFF1B4F72)),
                child: const Text("GÉNÉRER", style: TextStyle(color: Colors.white)),
              ),
            ),
          ],
        ),
      ),
    );
  }
}