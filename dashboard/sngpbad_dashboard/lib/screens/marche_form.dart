import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class MarcheForm extends StatefulWidget {
  final Function(String objet, String procedure) onSaved;

  const MarcheForm({super.key, required this.onSaved});

  @override
  State<MarcheForm> createState() => _MarcheFormState();
}

class _MarcheFormState extends State<MarcheForm> {
  final _formKey = GlobalKey<FormState>();
  final TextEditingController _objetController = TextEditingController();
  String? selectedProcedure;
  bool isSubmitting = false;

  final List<String> procedures = ['AOI', 'AON', 'CF'];

  @override
  void dispose() {
    _objetController.dispose();
    super.dispose();
  }

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
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Center(child: Container(width: 40, height: 4, decoration: BoxDecoration(color: Colors.grey[300], borderRadius: BorderRadius.circular(10)))),
            const SizedBox(height: 20),
            Text("Soumettre un nouveau dossier", style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold)),
            const SizedBox(height: 20),

            TextFormField(
              controller: _objetController,
              decoration: const InputDecoration(
                labelText: "Objet du marché", 
                hintText: "Ex: Acquisition de véhicules...",
                border: OutlineInputBorder(), 
                prefixIcon: Icon(Icons.edit)
              ),
              validator: (v) => v!.isEmpty ? "L'objet est obligatoire" : null,
            ),
            const SizedBox(height: 15),

            DropdownButtonFormField<String>(
              value: selectedProcedure,
              decoration: const InputDecoration(labelText: "Type de procédure", border: OutlineInputBorder()),
              items: procedures.map((p) => DropdownMenuItem(value: p, child: Text(p))).toList(),
              onChanged: (v) => setState(() => selectedProcedure = v),
              validator: (v) => v == null ? "Sélectionnez une procédure" : null,
            ),

            if (selectedProcedure == 'AOI')
              Container(
                margin: const EdgeInsets.only(top: 15),
                padding: const EdgeInsets.all(12),
                decoration: BoxDecoration(
                  color: Colors.amber.withOpacity(0.1), 
                  borderRadius: BorderRadius.circular(8), 
                  border: Border.all(color: Colors.amber)
                ),
                child: const Row(
                  children: [
                    Icon(Icons.gavel, color: Colors.amber),
                    SizedBox(width: 10),
                    Expanded(child: Text(
                      "Note: La procédure AOI nécessite un Avis de Non-Objection (ANO) préalable de la BAD.", 
                      style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.orange)
                    )),
                  ],
                ),
              ),

            const SizedBox(height: 30),

            SizedBox(
              width: double.infinity,
              height: 50,
              child: ElevatedButton(
                onPressed: isSubmitting ? null : () async {
                  if (_formKey.currentState!.validate()) {
                    setState(() => isSubmitting = true);
                    await widget.onSaved(_objetController.text, selectedProcedure!);
                    if (mounted) Navigator.pop(context);
                  }
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: const Color(0xFF27AE60), 
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8))
                ),
                child: isSubmitting 
                  ? const CircularProgressIndicator(color: Colors.white)
                  : const Text("ENREGISTRER ET SOUMETTRE", style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold)),
              ),
            ),
          ],
        ),
      ),
    );
  }
}