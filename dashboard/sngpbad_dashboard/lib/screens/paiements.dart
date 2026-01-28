import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class Paiements extends StatelessWidget {
  const Paiements({super.key});

  final Color badGreen = const Color(0xFF2ECC71);
  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color errorRed = const Color(0xFFC0392B);

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.only(bottom: 30),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildFinancialSummary(),
          const SizedBox(height: 25),
          
          // SECTION CRITIQUE : MAINLEVÉE & BLOCAGE
          _buildMainLeveeSection(),
          
          const SizedBox(height: 30),
          Text(
            "Historique des Virements & Chèques",
            style: GoogleFonts.montserrat(
                fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue),
          ),
          const SizedBox(height: 15),
          _buildPaymentsTable(),
        ],
      ),
    );
  }

  Widget _buildFinancialSummary() {
    return Row(
      children: [
        _buildStatCard("Total Encaissé", "8 450 000 000", Icons.account_balance_wallet, badGreen),
        const SizedBox(width: 15),
        _buildStatCard("En attente (Bloqué)", "1 200 000 000", Icons.lock_clock_outlined, errorRed),
        const SizedBox(width: 15),
        _buildStatCard("Reste à percevoir", "5 800 000 000", Icons.pending_actions, primaryBlue),
      ],
    );
  }

  Widget _buildMainLeveeSection() {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: errorRed.withOpacity(0.3)),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10)],
      ),
      child: Column(
        children: [
          // Header d'alerte
          Container(
            padding: const EdgeInsets.all(15),
            decoration: BoxDecoration(
              color: errorRed.withOpacity(0.1),
              borderRadius: const BorderRadius.vertical(top: Radius.circular(12)),
            ),
            child: Row(
              children: [
                Icon(Icons.gavel_rounded, color: errorRed),
                const SizedBox(width: 12),
                Text(
                  "PROCÉDURE DE MAINLEVÉE REQUISE (DÉCOMPTE N°5)",
                  style: GoogleFonts.inter(fontWeight: FontWeight.bold, color: errorRed),
                ),
              ],
            ),
          ),
          
          Padding(
            padding: const EdgeInsets.all(20),
            child: Row(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Checklist des documents
                Expanded(
                  flex: 3,
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const Text(
                        "Pour débloquer votre paiement, veuillez fournir les justificatifs suivants concernant vos imports de l'année en cours :",
                        style: TextStyle(fontSize: 13, color: Colors.black87),
                      ),
                      const SizedBox(height: 15),
                      _buildChecklistItem("Quitus Fiscal (DGI) à jour", true),
                      _buildChecklistItem("Attestation de régularité douanière", true),
                      _buildChecklistItem("Certificat de destination finale (Matériel)", false),
                      _buildChecklistItem("Copie de la mainlevée bancaire", false),
                    ],
                  ),
                ),
                const SizedBox(width: 20),
                // Actions
                Expanded(
                  flex: 2,
                  child: Container(
                    padding: const EdgeInsets.all(15),
                    decoration: BoxDecoration(
                      color: Colors.grey[50],
                      borderRadius: BorderRadius.circular(8),
                    ),
                    child: Column(
                      children: [
                        const Text("Action requise", style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12)),
                        const SizedBox(height: 10),
                        ElevatedButton.icon(
                          onPressed: () {},
                          icon: const Icon(Icons.upload_file, size: 18),
                          label: const Text("Uploader les pièces"),
                          style: ElevatedButton.styleFrom(
                            backgroundColor: primaryBlue,
                            foregroundColor: Colors.white,
                            minimumSize: const Size(double.infinity, 45),
                          ),
                        ),
                        const SizedBox(height: 10),
                        const Text(
                          "Délai moyen de traitement : 48h-72h après soumission.",
                          textAlign: TextAlign.center,
                          style: TextStyle(fontSize: 10, color: Colors.grey, fontStyle: FontStyle.italic),
                        ),
                      ],
                    ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildChecklistItem(String label, bool isDone) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4),
      child: Row(
        children: [
          Icon(
            isDone ? Icons.check_circle : Icons.radio_button_unchecked,
            color: isDone ? badGreen : Colors.grey,
            size: 18,
          ),
          const SizedBox(width: 10),
          Text(label, style: TextStyle(
            fontSize: 13, 
            decoration: isDone ? TextDecoration.lineThrough : null,
            color: isDone ? Colors.grey : Colors.black87
          )),
        ],
      ),
    );
  }

  Widget _buildStatCard(String title, String amount, IconData icon, Color color) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border(left: BorderSide(color: color, width: 5)),
          boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 5)],
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Icon(icon, color: color, size: 28),
            const SizedBox(height: 10),
            Text(title, style: const TextStyle(color: Colors.grey, fontSize: 13)),
            const SizedBox(height: 5),
            Text("$amount FCFA",
                style: GoogleFonts.inter(
                    fontWeight: FontWeight.bold, fontSize: 16, color: color)),
          ],
        ),
      ),
    );
  }

  Widget _buildPaymentsTable() {
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.black12),
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(12),
        child: DataTable(
          headingRowColor: MaterialStateProperty.all(Colors.grey[50]),
          columns: const [
            DataColumn(label: Text('DATE')),
            DataColumn(label: Text('DÉCOMPTE')),
            DataColumn(label: Text('RÉFÉRENCE')),
            DataColumn(label: Text('MONTANT NET')),
            DataColumn(label: Text('STATUT')),
          ],
          rows: [
            _buildDataRow("10/01/2026", "Décompte N°4", "VIR-BAD-882", "450 000 000", "Effectué", badGreen),
            _buildDataRow("---", "Décompte N°5", "BLOCAGE FISCAL", "2 100 000 000", "En attente", errorRed),
            _buildDataRow("15/11/2025", "Décompte N°3", "CHQ-BAD-102", "1 250 000 000", "Effectué", badGreen),
          ],
        ),
      ),
    );
  }

  DataRow _buildDataRow(String date, String num, String ref, String mt, String status, Color color) {
    return DataRow(cells: [
      DataCell(Text(date)),
      DataCell(Text(num, style: const TextStyle(fontWeight: FontWeight.bold))),
      DataCell(Text(ref, style: TextStyle(color: color == errorRed ? errorRed : Colors.black87, fontWeight: color == errorRed ? FontWeight.bold : FontWeight.normal))),
      DataCell(Text("$mt F", style: TextStyle(fontWeight: FontWeight.bold, color: primaryBlue))),
      DataCell(
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
          decoration: BoxDecoration(color: color.withOpacity(0.1), borderRadius: BorderRadius.circular(20)),
          child: Text(status, style: TextStyle(color: color, fontSize: 11, fontWeight: FontWeight.bold)),
        ),
      ),
    ]);
  }
}