import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class Conventions extends StatefulWidget {
  const Conventions({super.key});

  @override
  State<Conventions> createState() => _ConventionsState();
}

class _ConventionsState extends State<Conventions> {
  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color badGreen = const Color(0xFF2E7D32);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F7F6),
      body: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildHeader(),
            const SizedBox(height: 30),
            _buildFinancingOverview(), // Vue globale du financement
            const SizedBox(height: 30),
            Text(
              "Historique des Demandes (DRF / DPD)",
              style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue),
            ),
            const SizedBox(height: 15),
            Expanded(child: _buildDemandesTable()),
          ],
        ),
      ),
    );
  }

  Widget _buildHeader() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          "Suivi des Conventions & Décaissements",
          style: GoogleFonts.montserrat(fontSize: 24, fontWeight: FontWeight.bold, color: primaryBlue),
        ),
        const Text("Gestion des flux financiers entre la BAD et le Projet",
            style: TextStyle(color: Colors.grey, fontSize: 13)),
      ],
    );
  }

  Widget _buildFinancingOverview() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(15),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10)],
      ),
      child: Column(
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              _buildSimpleStat("Budget Total", "5 000 000 000 FCFA"),
              _buildSimpleStat("Décaissement", "1 250 000 000 FCFA"),
              _buildSimpleStat("Taux", "25 %", isProgress: true),
            ],
          ),
          const SizedBox(height: 20),
          LinearProgressIndicator(
            value: 0.25,
            backgroundColor: Colors.grey[200],
            color: badGreen,
            minHeight: 10,
            borderRadius: BorderRadius.circular(5),
          ),
        ],
      ),
    );
  }

  Widget _buildSimpleStat(String label, String value, {bool isProgress = false}) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(label, style: const TextStyle(color: Colors.grey, fontSize: 12)),
        Text(value, style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: isProgress ? badGreen : primaryBlue)),
      ],
    );
  }

  Widget _buildDemandesTable() {
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12)),
      child: SingleChildScrollView(
        child: DataTable(
          columns: const [
            DataColumn(label: Text('N° Demande')),
            DataColumn(label: Text('Type')),
            DataColumn(label: Text('Montant (FCFA)')),
            DataColumn(label: Text('État BAD')),
          ],
          rows: [
            _buildDataRow("DRF-008", "DRF", "250 000 000", "Approuvé", Colors.green),
            _buildDataRow("DPD-012", "DPD", "45 000 000", "En cours", Colors.orange),
            _buildDataRow("DRF-009", "DRF", "150 000 000", "Brouillon", Colors.grey),
          ],
        ),
      ),
    );
  }

  DataRow _buildDataRow(String ref, String type, String montant, String statut, Color color) {
    return DataRow(cells: [
      DataCell(Text(ref, style: const TextStyle(fontWeight: FontWeight.bold))),
      DataCell(Chip(label: Text(type, style: const TextStyle(fontSize: 10)), backgroundColor: primaryBlue.withOpacity(0.1))),
      DataCell(Text(montant)),
      DataCell(Row(
        children: [
          Icon(Icons.circle, size: 8, color: color),
          const SizedBox(width: 5),
          Text(statut),
        ],
      )),
    ]);
  }
}