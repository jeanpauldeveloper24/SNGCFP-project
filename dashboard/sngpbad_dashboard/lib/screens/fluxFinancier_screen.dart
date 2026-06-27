import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class FluxFinancierScreen extends StatefulWidget {
  const FluxFinancierScreen({super.key});

  @override
  State<FluxFinancierScreen> createState() => _FluxFinancierScreenState();
}

class _FluxFinancierScreenState extends State<FluxFinancierScreen> {
  // Simulation de données basée rigoureusement sur ton schéma de base de données
  final List<Map<String, dynamic>> _payments = [
    {
      "project_id": "PRJ-BOUNDIALI-2026",
      "demandeur": "SOGEA SATOM (CI)",
      "user_role": "prestataire",
      "montant": "450 000 000",
      "status_global": "encours",
      "verification_fiscale": "valide",
      "main_levee": "en_cours",
      "approbation": "Accordé",
      "decaissement": "en_cours",
      "references_bancaires": "BOA-CI-992831201",
      "payeur_final": "Comptable BAD Abidjan"
    },
    {
      "project_id": "SNGCFP-PROJECT",
      "demandeur": "Kouassi Yao Jean Paul",
      "user_role": "prestataire",
      "montant": "125 000 000",
      "status_global": "effectue",
      "verification_fiscale": "valide",
      "main_levee": "effectue",
      "approbation": "Accordé",
      "decaissement": "effectue",
      "references_bancaires": "ECOBANK-CI-110293",
      "payeur_final": "Trésor National CI"
    },
    {
      "project_id": "PRJ-BASSAM-M2",
      "demandeur": "BATIM-CI",
      "user_role": "prestataire",
      "montant": "85 000 000",
      "status_global": "refuse",
      "verification_fiscale": "rejete",
      "main_levee": "bloque",
      "approbation": "Rejeté",
      "decaissement": "bloque",
      "references_bancaires": "NSIA-BANK-88391",
      "payeur_final": "N/A"
    }
  ];

  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color errorRed = const Color(0xFFE74C3C);
  final Color textDark = const Color(0xFF1E1E2D);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F6F9),
      body: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildHeader(),
            const SizedBox(height: 24),
            _buildFinancialSummaryCards(),
            const SizedBox(height: 24),
            Expanded(
              child: Container(
                width: double.infinity,
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(12),
                  boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.02), blurRadius: 10)],
                  border: Border.all(color: Colors.grey.withOpacity(0.1)),
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    _buildTableToolbar(),
                    Expanded(
                      child: SingleChildScrollView(
                        scrollDirection: Axis.vertical,
                        child: SingleChildScrollView(
                          scrollDirection: Axis.horizontal,
                          child: Container(
                            constraints: BoxConstraints(minWidth: MediaQuery.of(context).size.width - 350),
                            child: DataTable(
                              headingRowColor: MaterialStateProperty.all(const Color(0xFFF8F9FA)),
                              dataRowMaxHeight: 65,
                              columns: _buildTableColumns(),
                              rows: _payments.map((payment) => _buildPaymentRow(payment)).toList(),
                            ),
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
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
          "Suivi des Flux Financiers",
          style: GoogleFonts.montserrat(fontSize: 26, fontWeight: FontWeight.bold, color: textDark),
        ),
        const SizedBox(height: 4),
        Text(
          "Ordonnancement, suivi des visas fiscaux, main-levées et états de décaissement",
          style: GoogleFonts.inter(fontSize: 13, color: Colors.grey[600]),
        ),
      ],
    );
  }

  Widget _buildFinancialSummaryCards() {
    return Row(
      children: [
        _buildKPIBlock("Total Demandes", "660 000 000 F", "Flux cumulés initiés", Icons.pull_request_rounded, primaryBlue),
        const SizedBox(width: 16),
        _buildKPIBlock("Décaissements Effectués", "125 000 000 F", "Fonds libérés", Icons.check_circle_rounded, Colors.green),
        const SizedBox(width: 16),
        _buildKPIBlock("Flux Bloqués / Refusés", "85 000 000 F", "Anomalies détectées", Icons.gpp_bad_rounded, errorRed),
      ],
    );
  }

  Widget _buildKPIBlock(String title, String value, String subtitle, IconData icon, Color color) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(8),
          border: Border(left: BorderSide(color: color, width: 4)),
          boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.01), blurRadius: 6)],
        ),
        child: Row(
          children: [
            Icon(icon, color: color, size: 32),
            const SizedBox(width: 16),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(title, style: GoogleFonts.inter(fontSize: 12, color: Colors.grey, fontWeight: FontWeight.w500)),
                const SizedBox(height: 4),
                Text(value, style: GoogleFonts.inter(fontSize: 18, fontWeight: FontWeight.bold, color: textDark)),
                Text(subtitle, style: GoogleFonts.inter(fontSize: 11, color: Colors.grey[500])),
              ],
            )
          ],
        ),
      ),
    );
  }

  Widget _buildTableToolbar() {
    return Padding(
      padding: const EdgeInsets.all(16.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            "Registre des requêtes de paiement",
            style: GoogleFonts.montserrat(fontSize: 15, fontWeight: FontWeight.bold, color: textDark),
          ),
          ElevatedButton.icon(
            onPressed: () {},
            icon: const Icon(Icons.refresh, size: 16),
            label: const Text("Actualiser les flux"),
            style: ElevatedButton.styleFrom(
              backgroundColor: primaryBlue,
              foregroundColor: Colors.white,
              textStyle: GoogleFonts.inter(fontSize: 12, fontWeight: FontWeight.w600),
            ),
          )
        ],
      ),
    );
  }

  List<DataColumn> _buildTableColumns() {
    return [
      DataColumn(label: Text('Projet ID', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Prestataire / Demandeur', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Montant', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Statut Global', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Fisc', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Main-Levée', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Décaissement', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Banque Ref', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
    ];
  }

  DataRow _buildPaymentRow(Map<String, dynamic> payment) {
    return DataRow(cells: [
      DataCell(Text(payment["project_id"], style: GoogleFonts.inter(fontWeight: FontWeight.bold, color: primaryBlue, fontSize: 12))),
      DataCell(Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(payment["demandeur"], style: GoogleFonts.inter(fontSize: 13, fontWeight: FontWeight.w500)),
          Text(payment["user_role"], style: GoogleFonts.inter(fontSize: 11, color: Colors.grey)),
        ],
      )),
      DataCell(Text("${payment["montant"]} F", style: GoogleFonts.inter(fontWeight: FontWeight.bold))),
      
      // Statut Global : demande, encours, effectue, refuse
      DataCell(_buildStatusBadge(
        payment["status_global"],
        {
          "demande": Colors.blue,
          "encours": Colors.amber[800]!,
          "effectue": Colors.green,
          "refuse": errorRed
        },
      )),

      // Vérification Fiscale : en_attente, valide, rejete
      DataCell(_buildStatusBadge(
        payment["verification_fiscale"],
        {
          "en_attente": Colors.grey,
          "valide": Colors.green,
          "rejete": errorRed
        },
      )),

      // Main-Levée : bloque, en_cours, effectue
      DataCell(_buildStatusBadge(
        payment["main_levee"],
        {
          "bloque": errorRed,
          "en_cours": Colors.blue,
          "effectue": Colors.green
        },
      )),

      // Décaissement : bloque, en_cours, effectue
      DataCell(_buildStatusBadge(
        payment["decaissement"],
        {
          "bloque": errorRed,
          "en_cours": Colors.blue,
          "effectue": Colors.green
        },
      )),

      DataCell(Text(
        payment["references_bancaires"].toString(),
        style: GoogleFonts.inter(fontFamily: 'monospace', fontSize: 12, color: Colors.grey[700]),
      )),
    ]);
  }

  Widget _buildStatusBadge(String value, Map<String, Color> colorMap) {
    Color color = colorMap[value] ?? Colors.grey;
    String label = value.replaceAll('_', ' ').toUpperCase();

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
      decoration: BoxDecoration(
        color: color.withOpacity(0.1),
        borderRadius: BorderRadius.circular(4),
        border: Border.all(color: color.withOpacity(0.3), width: 1),
      ),
      child: Text(
        label,
        style: GoogleFonts.inter(color: color, fontSize: 10, fontWeight: FontWeight.bold),
      ),
    );
  }
}