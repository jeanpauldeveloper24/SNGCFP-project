import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class SubmitInvoice extends StatefulWidget {
  const SubmitInvoice({super.key});

  @override
  State<SubmitInvoice> createState() => _SubmitInvoiceState();
}

class _SubmitInvoiceState extends State<SubmitInvoice> {
  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color sngpGreen = const Color(0xFF27AE60);

  // Liste fictive des factures soumises
  final List<Map<String, dynamic>> factures = [
    {"ref": "FAC-2026-001", "montant": "12 500 000", "date": "05/02/2026", "statut": "Payée", "color": Colors.green},
    {"ref": "FAC-2026-002", "montant": "8 000 000", "date": "10/02/2026", "statut": "Vérification", "color": Colors.orange},
  ];

  void _showInvoiceModal() {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      shape: const RoundedRectangleBorder(borderRadius: BorderRadius.vertical(top: Radius.circular(20))),
      builder: (context) => const ModalSoumissionFacture(),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F7F6),
      appBar: AppBar(
        title: Text("Mes Factures", style: GoogleFonts.montserrat(fontWeight: FontWeight.bold)),
        backgroundColor: Colors.white,
        foregroundColor: primaryBlue,
        elevation: 0,
      ),
      floatingActionButton: FloatingActionButton.extended(
        onPressed: _showInvoiceModal,
        backgroundColor: primaryBlue,
        icon: const Icon(Icons.upload_file, color: Colors.white),
        label: const Text("Soumettre une facture", style: TextStyle(color: Colors.white)),
      ),
      body: Padding(
        padding: const EdgeInsets.all(20.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildQuickStats(),
            const SizedBox(height: 25),
            Text("Historique des soumissions", 
                style: GoogleFonts.montserrat(fontSize: 16, fontWeight: FontWeight.bold, color: primaryBlue)),
            const SizedBox(height: 15),
            Expanded(
              child: ListView.builder(
                itemCount: factures.length,
                itemBuilder: (context, index) => _buildInvoiceCard(factures[index]),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildQuickStats() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: primaryBlue,
        borderRadius: BorderRadius.circular(15),
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          _statItem("En attente", "1", Colors.orangeAccent),
          _statItem("Payées", "1", Colors.greenAccent),
          _statItem("Total (FCFA)", "20.5M", Colors.white),
        ],
      ),
    );
  }

  Widget _statItem(String label, String value, Color color) {
    return Column(
      children: [
        Text(label, style: const TextStyle(color: Colors.white70, fontSize: 12)),
        Text(value, style: TextStyle(color: color, fontSize: 18, fontWeight: FontWeight.bold)),
      ],
    );
  }

  Widget _buildInvoiceCard(Map<String, dynamic> item) {
    return Card(
      margin: const EdgeInsets.only(bottom: 12),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      child: ListTile(
        leading: const Icon(Icons.description_outlined, color: Colors.blueGrey),
        title: Text(item['ref'], style: const TextStyle(fontWeight: FontWeight.bold)),
        subtitle: Text("Soumise le ${item['date']}"),
        trailing: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.end,
          children: [
            Text("${item['montant']} FCFA", style: TextStyle(fontWeight: FontWeight.bold, color: primaryBlue)),
            Text(item['statut'], style: TextStyle(color: item['color'], fontSize: 12, fontWeight: FontWeight.bold)),
          ],
        ),
      ),
    );
  }
}

// --- MODALE DE SOUMISSION DE FACTURE ---

class ModalSoumissionFacture extends StatefulWidget {
  const ModalSoumissionFacture({super.key});

  @override
  State<ModalSoumissionFacture> createState() => _ModalSoumissionFactureState();
}

class _ModalSoumissionFactureState extends State<ModalSoumissionFacture> {
  final _formKey = GlobalKey<FormState>();
  String? selectedMarche;

  @override
  Widget build(BuildContext context) {
    return Padding(
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
            Text("Nouvelle Facture numérique", 
                style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold)),
            const SizedBox(height: 20),
            
            DropdownButtonFormField<String>(
              decoration: const InputDecoration(labelText: "Lier au Marché", border: OutlineInputBorder()),
              items: const [
                DropdownMenuItem(value: "M001", child: Text("Construction centre de santé")),
                DropdownMenuItem(value: "M002", child: Text("Aménagement voirie")),
              ],
              onChanged: (v) => selectedMarche = v,
              validator: (v) => v == null ? "Sélectionnez un marché" : null,
            ),
            const SizedBox(height: 15),
            
            TextFormField(
              keyboardType: TextInputType.number,
              decoration: const InputDecoration(
                labelText: "Montant TTC", 
                suffixText: "FCFA",
                border: OutlineInputBorder()
              ),
              validator: (v) => v!.isEmpty ? "Entrez le montant" : null,
            ),
            const SizedBox(height: 15),
            
            // Simulation de téléchargement de fichier
            Container(
              padding: const EdgeInsets.all(15),
              decoration: BoxDecoration(
                border: Border.all(color: Colors.grey.shade300),
                borderRadius: BorderRadius.circular(8),
                color: Colors.grey.shade50,
              ),
              child: const Row(
                children: [
                  Icon(Icons.picture_as_pdf, color: Colors.red),
                  SizedBox(width: 10),
                  Text("Joindre la facture (PDF signé)", style: TextStyle(fontSize: 13, color: Colors.blueGrey)),
                  Spacer(),
                  Icon(Icons.add_circle_outline, color: Colors.blue),
                ],
              ),
            ),
            
            const SizedBox(height: 25),
            
            ElevatedButton(
              onPressed: () {
                if (_formKey.currentState!.validate()) {
                  Navigator.pop(context);
                  // Logique d'ajout à implémenter ici
                }
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: const Color(0xFF27AE60),
                minimumSize: const Size(double.infinity, 55),
              ),
              child: const Text("ENVOYER LA FACTURE", style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold)),
            ),
          ],
        ),
      ),
    );
  }
}